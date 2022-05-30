<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Services\PaymentDataService\PaymentDataService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    private $paymentDataService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PaymentDataService $paymentDataService)
    {
        $this->paymentDataService = $paymentDataService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function submit(Request $request){

        $customer = Customer::create([
            'firstName' => $request->get('firstName'),
            'lastName' => $request->get('lastName'),
            'telephone' => $request->get('telephone'),
            'city' => $request->get('city'),
            'zip' => $request->get('zip'),
            'address' => $request->get('house') .' '. $request->get('street'),
        ]);
        $paymentHistory = CustomerPayment::create([
            'owner_name' => $request->get('accOwner'),
            'iban' => $request->get('iban'),
            'customer_id' => $customer->id,
        ]);

        $paymentResponse = $this->paymentDataService->savePaymentInfo(['customerId' => $customer->id,
                                                    'iban' => $request->get('iban'),
                                                    'owner' => $request->get('accOwner')]);
        if($paymentResponse->successful()){
            CustomerPayment::where('id', '=', $paymentHistory->id)->update(['payment_data_id' => $paymentResponse->json()['paymentDataId']]);
            return ['success' => true, 'paymentId' => $paymentResponse->json()['paymentDataId']];
        }
        return ['success' => false];

    }
}
