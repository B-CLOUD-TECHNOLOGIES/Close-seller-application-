<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;

class VendorTransactionController extends Controller
{
  /**
     * Display all transactions for the authenticated vendor.
     */

    public function showTransactions()
    {
        return view('vendors.transaction.index');
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
                    'orderId'       => $order->order_no,
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