<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerPayment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        CustomerPayment::create([
            'owner_name' => $request->get('accOwner'),
            'iban' => $request->get('iban'),
            'customer_id' => $customer->id,
        ]);
    }
}
