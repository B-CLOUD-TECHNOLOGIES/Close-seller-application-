<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\BankDetails;
use App\Models\Vendor;
use App\Models\notification;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class VendorBankController extends Controller
{

    
        public function showAccountInfo()
    {
        $vendor = auth('vendor')->user();
        $bankDetails = $vendor->bankDetails; // may be null if not saved yet

        return view('vendors.settings.acc-info', compact('bankDetails'));
    }
    
    public function getBanks()
{
    try {
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->get('https://api.paystack.co/bank');

        if ($response->successful()) {
            $data = $response->json();

            // Paystack returns: { "status": true, "message": "Banks retrieved", "data": [...] }
            // We'll normalize it so the frontend sees consistent structure:
            return response()->json([
                'status' => true,
                'data' => collect($data['data'])->map(function ($bank) {
                    return [
                        'name' => $bank['name'],
                        'code' => $bank['code'],
                    ];
                })
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to fetch banks from Paystack.'
        ], 500);

    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Error fetching banks: ' . $e->getMessage()
        ], 500);
    }
}

  public function verifyAccount(Request $request)
{
    $request->validate([
        'account_number' => 'required|string',
        'bank_code' => 'required|string',
    ]);

    $url = "https://api.paystack.co/bank/resolve?account_number={$request->account_number}&bank_code={$request->bank_code}";

    $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))->get($url);

    if ($response->successful() && isset($response->json()['data'])) {
        return response()->json([
            'status' => true,
            'data' => $response->json()['data'],
        ]);
    }

    return response()->json([
        'status' => false,
        'message' => $response->json()['message'] ?? 'Unable to verify account details.'
    ], 400);
}

   public function saveDetails(Request $request)
{
    $request->validate([
        'acctNo'   => 'required|digits:10',
        'bankCode' => 'required|string',
        'bankName' => 'required|string',
        'acctName' => 'required|string',
    ]);

    $vendorId = Auth::guard('vendor')->id();

    if (!$vendorId) {
        return response()->json([
            'status' => false,
            'message' => 'User not authenticated.',
        ], 401);
    }

    $bankDetail = BankDetails::updateOrCreate(
        ['vendor_id' => $vendorId],
        [
            'bankCode' => $request->bankCode,
            'bankName' => $request->bankName,
            'acctName' => $request->acctName,
            'acctNo'   => $request->acctNo,
        ]
    );

    // ✅ Create notification using helper method
    notification::insertRecord(
        $vendorId,
        'vendor',
        'Bank Details Updated',
        '/vendor/settings/bank',
        'Your bank account details were successfully updated on ' . now()->format('M d, Y H:i A'),
        false
    );

    return response()->json([
        'status' => true,
        'message' => 'Bank details saved successfully!',
        'data' => $bankDetail,
    ]);
}

}
