<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorPayout;
use Carbon\Carbon;

class VendorTransactionController extends Controller
{
  /**
     * Display all transactions for the authenticated vendor.
     */

    public function showTransactions()
    {
        return view('vendors.transaction.index');
    }

    public function showTransactionDetails($orderId)
{
    try {
        $vendor = Auth::guard('vendor')->user();

        if (!$vendor) {
            return redirect()->route('vendor.transactions')->with('error', 'Unauthorized access.');
        }

        // Fetch payouts for the vendor and order ID
        $payouts = VendorPayout::where('vendor_id', $vendor->id)
            ->where('order_id', $orderId)
            ->get();

        if ($payouts->isEmpty()) {
            return redirect()->route('vendor.transactions')->with('error', 'Transaction not found.');
        }

        // Sum totals
        $grossAmount = $payouts->sum('gross_amount');
        $feeAmount   = $payouts->sum('fee_amount');
        $netAmount   = $payouts->sum('amount');

        // Get transaction info from first payout
        $firstPayout = $payouts->first();

        // Decode Paystack response JSON
        $response = json_decode($firstPayout->paystack_response, true);
        $recipient = $response['recipient_details'] ?? [];
        $createdAt = $response['createdAt'] ?? $firstPayout->created_at;

        return view('vendors.transaction.transaction-details', [
            'orderId'        => $orderId,
            'grossAmount'    => $grossAmount,
            'feeAmount'      => $feeAmount,
            'netAmount'      => $netAmount,
            'status'         => ucfirst($firstPayout->status),
            'reference'      => $firstPayout->transfer_reference,
            'transactionId'  => $firstPayout->paystack_transfer_id,
            'recipientName'  => $recipient['account_name'] ?? 'N/A',
            'bankName'       => $recipient['bank_name'] ?? 'N/A',
            'accountNumber'  => $recipient['account_number'] ?? 'N/A',
            'createdAt'      => Carbon::parse($createdAt)->format('M jS, Y h:i A'),
        ]);
    } catch (\Exception $e) {
        return redirect()->route('vendor.transactions')->with('error', 'Error loading transaction: ' . $e->getMessage());
    }
}
    public function index(Request $request)
    {
        try {
            $vendor = Auth::guard('vendor')->user();

            if (!$vendor) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ], 401);
            }

            $query = Orders::query()
                ->where('is_delete', false)
                ->where('user_id', $vendor->id) // assuming vendor owns the order
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
                    'amount'        => (float) $order->total_amount,
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
        return match ($status) {
            0 => 'Canceled',
            1 => 'Processing',
            2 => 'In Progress',
            3 => 'Completed',
            default => 'Unknown',
        };
    }
}