<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\VendorPayout;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserTransactionController extends Controller
{
    //
    public function userTransactions()
    {
        return view("users.transactions.index");
    }


    public function showTransactionDetails($orderId)
    {
        try {
            Log::info("Order_ID: " . $orderId);
            $user = Auth::guard('web')->user();

            if (!$user) {
                return redirect()->route('user.transactions')->with('error', 'Unauthorized access.');
            }

            // Fetch payouts for the user
            $payouts = Orders::where('user_id', $user->id)
                ->where('id', $orderId)
                ->first();

            if (!$payouts) {
                return redirect()->route('user.transactions')->with('error', 'Transaction not found.');
            }



            Log::info("Payout Details: " . $payouts);

            $payastack_percent_fee = $payouts->payment_data['paystack_percentage_fee'];
            $platform_fee = $payouts->payment_data['platform_fee'];
            $paystack_fixed_fee = $payouts->payment_data['paystack_fixed_fee'];
            $total_fees = $payouts->payment_data['total_fees'];
            $netAmount = $payouts->payment_data['product_value'];
            $charges = (int) $platform_fee + (int) $payastack_percent_fee + (int) $paystack_fixed_fee;


            return view("users.transactions.transaction-details", [
                'order' => $payouts,
                "charges" => $charges,
                "total" => $total_fees,
                "netAmount" => $netAmount,
                'createdAt'      => Carbon::parse($payouts->created_at)->format('M jS, Y h:i A'),
            ]);
        } catch (\Exception $e) {
            return redirect()->route('user.transactions')->with('error', 'Error loading transaction: ' . $e->getMessage());
        }
    }




    public function userFetchTransactions(Request $request)
    {
        try {
            $user = Auth::guard('web')->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ], 401);
            }

            $query = Orders::query()
                ->where('is_delete', false)
                ->where('user_id', $user->id) // assuming vendor owns the order
                ->orderBy('created_at', 'desc');

            // Filter by date range (optional)
            if ($request->has(['startDate', 'endDate'])) {
                $startDate = $request->input('startDate');
                $endDate = $request->input('endDate');

                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [
                        $startDate . ' 00:00:00',
                        $endDate . ' 23:59:59'
                    ]);
                }
            }

            $transactions = $query->get()->map(function ($order) {
                return [
                    'transactionId' => $order->transaction_id,
                    'orderNo'       => $order->order_no,
                    'orderId'       => $order->id,
                    'amount' => round((float) $order->payment_data["total_fees"], 2),
                    'date'          => $order->created_at->format('Y-m-d'),
                    'status'        => $this->mapStatus($order->status),
                    'isPayment'     => (bool) $order->is_payment,
                    'paymentMethod' => $order->payment_method,
                ];
            });

            return response()->json([
                'success' => true,
                'transactions' => $transactions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching transactions: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper to map numeric status to readable text.
     */

    private function mapStatus($status)

    {
        switch ($status) {
            case 0:
                return 'Canceled';
            case 1:
                return 'Processing';
            case 2:
                return 'In Progress';
            case 3:
                return 'Completed';
            default:
                return 'Unknown';
        }
    }
}
