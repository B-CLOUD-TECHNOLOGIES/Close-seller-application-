<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\orderMailer;
use App\Models\BankDetails;
use App\Models\Cart;
use App\Models\notification;
use App\Models\Orders;
use App\Models\OrderTracking;
use App\Models\PlatformEarning;
use App\Models\products;
use App\Models\VendorPayout;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use MusheAbdulHakim\Paystack\Paystack;



class PaymentController extends Controller
{
    /**
     * Initialize Paystack Payment
     */
    public function initializePayment(Request $request, $encodedOrder)
    {
        $orderId = base64_decode($encodedOrder);
        $order = Orders::with(['items.product', 'user'])->findOrFail($orderId);
        $user = $order->user;

        $productValue = $order->total_amount;
        $sessionTotal = $amountToCharge = session()->get('checkout_total');
        $paystackandPlatformFee = session()->get('checkout_charge');
        $payFixedFee = session()->get('checkout_extra');
        $payPctFee = $platformFee = (int) ($paystackandPlatformFee / 2);
        $amountInKobo = (int) ($amountToCharge * 100);


        $hasAdminProducts = $order->items->contains(fn($item) => $item->product->product_owner === 'admin');

        $metadata = [
            'order_id' => $order->id,
            'fee_breakdown' => [
                'product_value' => $productValue,
                'paystack_percentage_fee' => $payPctFee,
                'paystack_fixed_fee' => $payFixedFee,
                'platform_fee' => $platformFee,
                'total_fees' => $sessionTotal,
            ],
            'has_admin_products' => $hasAdminProducts,
        ];


        $payload = [
            'amount'       => $amountInKobo,
            'email'        => $user->email,
            'reference'    => uniqid('paystack_'),
            'currency'     => 'NGN',
            'callback_url' => route('paystack.callback'),
            'metadata'     => $metadata,
        ];

        // ✅ Add subaccount configuration if order contains admin products
        if ($hasAdminProducts) {
            $payload['subaccount'] = 'ACCT_ciw6daxerm8dfnc';
            $payload['transaction_charge'] = 0; // 0% to main account

            // Store split details in metadata
            $metadata['subaccount_id'] = 'ACCT_ciw6daxerm8dfnc';
            $metadata['split_config'] = [
                'subaccount_percentage' => 100,
                'main_account_percentage' => 0,
            ];

            // Update payload metadata with subaccount info
            $payload['metadata'] = $metadata;
        }

        try {
            $secretKey = config('paystack.secret_key');
            $paystack = Paystack::client($secretKey);

            $response = $paystack->transaction()->initialize($payload);

            if (!isset($response['status']) || !$response['status']) {
                Log::error('Paystack init failed', ['resp' => $response]);
                return back()->with('error', 'Failed to initialize payment.');
            }

            $order->update([
                'payment_data' => json_encode($metadata['fee_breakdown']),
                'reference'    => $payload['reference'],
            ]);

            return redirect()->away($response['data']['authorization_url']);
        } catch (\Exception $e) {
            Log::error('Paystack Exception', ['msg' => $e->getMessage()]);
            return back()->with('error', 'Payment initialization error.');
        }
    }





    public function handleCallback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return back()->with('error', 'Missing payment reference.');
        }

        DB::beginTransaction();

        try {
            // Initialize Paystack client
            $secretKey = config('paystack.secret_key');
            $paystack  = Paystack::client($secretKey);

            // Verify payment
            $verify = $paystack->transaction()->verify($reference);

            if (!$verify['status'] || $verify['data']['status'] !== 'success') {
                throw new \Exception('Payment not successful.');
            }

            // Extract metadata and order
            $metadata = $verify['data']['metadata'] ?? [];
            $orderId  = $metadata['order_id'] ?? null;

            if (!$orderId) {
                throw new \Exception('Order ID missing in payment metadata.');
            }

            $order = Orders::findOrFail($orderId);

            // Update order details
            $order->update([
                'is_payment'     => 1,
                'status'         => 3,
                'transaction_id' => $verify['data']['id'],
                'payment_data'   => $metadata['fee_breakdown'] ?? null,
            ]);

            // Process each order item
            foreach ($order->items as $item) {
                OrderTracking::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'status'     => 1,
                ]);

                $product = products::find($item->product_id);
                if (!$product) continue;

                $grossAmount = $item->total_price * $item->quantity;
                $platformFee = 10.00;
                $netAmount   = $grossAmount - $platformFee;

                if ($product->product_owner === 'admin') {
                    // --- Admin-owned product ---
                    VendorPayout::create([
                        'vendor_id'          => 0,
                        'order_id'           => $order->id,
                        'product_id'         => $product->id,
                        'gross_amount'       => $grossAmount,
                        'fee_amount'         => 0,
                        'amount'             => $grossAmount,
                        'status'             => 'success',
                        'transfer_reference' => $reference,
                    ]);

                    PlatformEarning::create([
                        'order_id'       => $order->id,
                        'amount'         => 0,
                        'transaction_id' => $verify['data']['id'],
                    ]);


                    // ===================================
                    // 🔔 SEND NOTIFICATIONS TO ADMIN ₦
                    // ===================================
                    notification::insertRecord(
                        null,
                        'admin',
                        '💳 New Payment Received',
                        url('admin/orders/details/' . $order->id),
                        "You've received ₦" . number_format($grossAmount, 2) . " for Order #" . $order->order_no,
                        true
                    );
                } else {
                    // --- Vendor-owned product ---
                    $bank = BankDetails::where('vendor_id', $product->vendor_id)->first();
                    if (!$bank) {
                        throw new \Exception("Bank details missing for vendor ID {$product->vendor_id}");
                    }

                    // Step 1: Ensure the vendor has a recipient code
                    if (empty($bank->recipient_code)) {
                        $recipient = $paystack->transferrecipient()->create([
                            'type'           => 'nuban',
                            'name'           => $bank->acctName,
                            'account_number' => $bank->acctNo,
                            'bank_code'      => $bank->bankCode,
                            'currency'       => 'NGN',
                        ]);

                        $bank->update(['recipient_code' => $recipient['data']['recipient_code']]);
                    }

                    // Step 2: Initiate transfer
                    $transfer = $paystack->transfer()->init([
                        'source'     => 'balance',
                        'amount'     => $netAmount * 100,
                        'recipient'  => $bank->recipient_code,
                        'reason'     => 'Vendor payment for Order #' . $order->order_no,
                    ]);

                    // Step 3: Get recipient details from Paystack API
                    $recipientId = $transfer['data']['recipient'] ?? null;
                    $recipientDetails = null;

                    if ($recipientId) {
                        try {
                            $recipientResponse = Http::withToken(config('paystack.secret_key'))
                                ->get("https://api.paystack.co/transferrecipient/{$recipientId}")
                                ->json();

                            $recipientDetails = $recipientResponse['data']['details'] ?? null;
                        } catch (\Throwable $e) {
                            Log::error('Error fetching Paystack recipient details: ' . $e->getMessage());
                        }
                    }

                    // Step 4: Merge recipient info into transfer data
                    $paystackData = $transfer['data'] ?? [];
                    if ($recipientDetails) {
                        $paystackData['recipient_details'] = [
                            'bank_name'      => $recipientDetails['bank_name'] ?? null,
                            'account_number' => $recipientDetails['account_number'] ?? null,
                            'account_name'   => $recipientDetails['account_name'] ?? null,
                        ];
                    }

                    // Step 5: Save payout record
                    VendorPayout::create([
                        'vendor_id'            => $product->vendor_id,
                        'order_id'             => $order->id,
                        'product_id'           => $product->id,
                        'gross_amount'         => $grossAmount,
                        'fee_amount'           => $platformFee,
                        'amount'               => $netAmount,
                        'paystack_transfer_id' => $transfer['data']['id'] ?? null,
                        'transfer_reference'   => $transfer['data']['reference'] ?? null,
                        'status'               => $transfer['data']['status'] ?? 'pending',
                        'paystack_response'    => json_encode($paystackData, JSON_PRETTY_PRINT),
                    ]);


                    PlatformEarning::create([
                        'order_id'       => $order->id,
                        'amount'         => $platformFee,
                        'transaction_id' => $verify['data']['id'],
                    ]);

                    // ===================================
                    // 🔔 SEND NOTIFICATIONS TO VENDOR ₦
                    // ===================================
                    notification::insertRecord(
                        $product->vendor_id,
                        'vendor',
                        '💳 New Payment Received',
                        url('vendors/order-summary/' . $order->id),
                        "Dear Vendor, You've received " . number_format($grossAmount, 2) . " for Order #" . $order->order_no,
                        false
                    );


                    // ===================================
                    // 🔔 SEND NOTIFICATIONS TO ADMIN ₦
                    // ===================================
                    notification::insertRecord(
                        null,
                        'admin',
                        '💳 New Payment Processed',
                        url('admin/orders/details/' . $order->id),
                        "Vendor " . $bank->acctName . " (ID: " . $product->vendor_id . ") has received ₦" . number_format($netAmount, 2) . " for Order #" . $order->order_no .
                            ". Gross amount: ₦" . number_format($grossAmount, 2) .
                            ", Fees: ₦" . number_format(($grossAmount - $netAmount), 2),
                        true
                    );
                }
            }



            // --- Clear cart for the user ---
            Cart::where('user_id', $order->user_id)->delete();

            // ===================================
            // 🔔 SEND NOTIFICATIONS TO USERS ₦
            // ===================================
            notification::insertRecord(
                $order->user_id,
                'user',
                'Order Confirmed',
                url('users/order/summary/' . $order->id),
                " Thank you for your order #" . $order->order_no . "
                        Order Date: " . Carbon::create($order->created_at)->format('F j, Y') . "
                        Payment Method: " . $order->payment_method . "
                        Amount Paid: ₦" . number_format($order->total_amount, 2) . " Your order is now being processed. You'll receive another notification when your items ship.",
                false
            );

            // --- Send confirmation email ---
            try {
                Mail::to($order->email)->send(new \App\Mail\orderMailer(
                    'Order Confirmation - #' . $order->order_no,
                    'Thank you for your purchase!',
                    $order,                    // $getOrder
                    $order->items,             // $orderItems
                    $order->created_at         // $createdAt
                ));
            } catch (\Throwable $mailError) {
                Log::error('Order Confirmation Mail Error', [
                    'order_id' => $order->id,
                    'message'  => $mailError->getMessage(),
                ]);
            }

            DB::commit();

            // ✅ Clear checkout session data
            session()->forget([
                'checkout_subtotal',
                'checkout_charge',
                'checkout_extra',
                'checkout_total',
            ]);


            $notification = [
                "message" => "Payment Successful",
                "alert-type" => "success",
            ];

            return redirect()->route('payment.success')->with($notification);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Paystack Callback Error', [
                'reference' => $reference,
                'message'   => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
            ]);


            $notification = [
                "message" => "Error verifying or processing payment.",
                "alert-type" => "error",
            ];


            return redirect()->route('payment.failed')->with($notification);
        }
    }



    public function paymentSuccess()
    {
        return view("frontend.payment-success");
    }


    public function paymentFailed()
    {
        return view("frontend.payment-failed");
    }




    /**
     * Handle Paystack Callback (after payment)
     */
    // public function handleCallback(Request $request)
    // {
    //     $reference = $request->query('reference');
    //     if (!$reference) {
    //         return back()->with('error', 'Missing payment reference.');
    //     }

    //     try {
    //         $secretKey = config('paystack.secret_key');
    //         $paystack = Paystack::client($secretKey);

    //         $verify = $paystack->transaction()->verify($reference);

    //         if ($verify['status'] && $verify['data']['status'] === 'success') {
    //             $metadata = $verify['data']['metadata'];
    //             $orderId = $metadata['order_id'];

    //             $order = Orders::find($orderId);
    //             if ($order) {
    //                 $order->update([
    //                     'is_payment'     => 1,
    //                     'status'         => 3,
    //                     'transaction_id' => $verify['data']['id'],
    //                 ]);
    //             }

    //             return redirect()->route('user.orders')->with('success', 'Payment successful.');
    //         }

    //         return back()->with('error', 'Payment not successful.');
    //     } catch (\Exception $e) {
    //         Log::error('Paystack Verify Error', ['error' => $e->getMessage()]);
    //         return back()->with('error', 'Error verifying payment.');
    //     }
    // }


    /**
     * Handle Paystack Webhook (server-to-server confirmation)
     */
    // public function handleWebhook(Request $request, Paystack $paystack)
    // {
    //     $secret = config('paystack.secretKey'); // your Paystack secret key

    //     // ✅ Step 1: Verify Signature
    //     $signature = $request->header('x-paystack-signature');
    //     $payload = $request->getContent();

    //     if (!$signature || (hash_hmac('sha512', $payload, $secret) !== $signature)) {
    //         Log::warning('⚠️ Invalid Paystack Signature Attempt', [
    //             'ip' => $request->ip(),
    //             'signature' => $signature,
    //         ]);
    //         return response('Invalid signature', 401);
    //     }

    //     // ✅ Step 2: Decode Payload
    //     $data = json_decode($payload, true);
    //     $reference = $data['data']['reference'] ?? null;

    //     if (!$reference) {
    //         return response('Missing reference', 400);
    //     }

    //     // ✅ Step 3: Verify with Paystack API
    //     try {
    //         $verified = $paystack->transaction->verify($reference);
    //         if (!$verified || !$verified->status || $verified->data->status !== 'success') {
    //             Log::warning('❌ Paystack Webhook Verification Failed', ['data' => $data]);
    //             return response('Invalid transaction', 400);
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Paystack Webhook Verify Error', [
    //             'error' => $e->getMessage(),
    //             'reference' => $reference,
    //         ]);
    //         return response('Error verifying transaction', 500);
    //     }

    //     // ✅ Step 4: Update Database Safely
    //     DB::beginTransaction();
    //     try {
    //         $orderId = $verified->data->metadata->order_id ?? null;
    //         if (!$orderId) {
    //             throw new \Exception('Missing order_id in metadata');
    //         }

    //         $order = Orders::findOrFail($orderId);

    //         $order->update([
    //             'is_payment'     => 1,
    //             'status'         => 3,
    //             'transaction_id' => $verified->data->id,
    //         ]);

    //         // TODO: trigger email receipt, vendor payment split, etc.

    //         DB::commit();
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         Log::error('Webhook DB Transaction Error', ['error' => $e->getMessage()]);
    //         return response('DB Error', 500);
    //     }

    //     return response('OK', 200);
    // }
}
