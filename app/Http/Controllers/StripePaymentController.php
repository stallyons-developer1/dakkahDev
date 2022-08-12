<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Session;
use Stripe;

class StripePaymentController extends Controller
{
    //
    public function index(){
        return view('payment');
    }
    public function process(Request $request)
    {
        try {
            $subscription = $request['subscription'];
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $stripe = Stripe\Charge::create ([
                "amount" => $subscription['amount'] * 100,
                "currency" => "SAR",
                "source" => $subscription['stripeToken'],
                "description" => "This payment is tested purpose phpcodingstuff.com"
            ]);

            Session::flash('success', 'Payment successful!');
            $user_id = session()->get('user') ? session()->get('user')['user_id']:0;
            $data = ['s_payment_id'=>$stripe['id'],'user_id'=>$user_id,'course_id'=>$subscription['course_id'],'payment_type'=>'card','amount'=>$stripe['amount']/100,'is_payed'=>1,'vat'=>'1'];
            $result = Payment::create($data);
            if ($result)
                return response()->json(['data' => $data , 'message'=>'Payment Subscription Successfully'],200);

        }catch (Exception $exception){
//            return $exception->getMessage();
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],200);

        }

    }
}
