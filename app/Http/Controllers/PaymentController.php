<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    //
    public function createChargers(Request $request){
        try {
            $charges = [
                'amount'=>100,'currency'=>'SAR','customer'=>
                    ["first_name"=> "test",
                        "middle_name"=> "test",
                        "threeDSecure"=> true,
                        "last_name"=> "test",
                        "email"=> "test@test.com"],
                "source"=>["id"=>"src_sa.mada"] ,
                "post"=>["url"=>"http://127.0.0.1:8000/api/payment/store"],
                "redirect"=>["url"=> "http://127.0.0.1:8000/payment/view/"],
                "phone"=> [ "country_code"=>"965","number"=>"50000000"]
            ];
            $response = Http::withHeaders(
                ['Authorization' => 'Bearer '.env('TABE_SECRIT_KEY')]
            )->post(env('TABE_URL'), $charges);
            return response()->json(['data'=>$response->json(),'message'=>''],200);
        }catch (Exception $exception){
            return response()->json(['data'=>[],'message'=>$exception->getMessage()],$exception->getCode());
        }
    }
    public function getChargers(Request $request)
    {
        try {
            $response = Http::accept('application/json')->withHeaders(
                ['Authorization' => 'Bearer '.env('TABE_SECRIT_KEY')])
                ->get(env('TABE_URL').'/'.$request['id']);
            return response()->json(['data'=>$response->json(),'message'=>''],200);
            }catch (Exception $exception){
            return response()->json(['data'=>[],'message'=>$exception->getMessage()],$exception->getCode());
        }

    }
    public function store(Request $request){
        try {
            $id = session()->get('user_id')[0];
            $is_payed = 0;
            if ($request['data']['status'] == 'Captured')
                $is_payed = 1;
            $data = ['user_id'=>$id , 's_payment_id'=>$request['data']['id'],'payment_type'=>'card','status'=>$request['data']['status'],'amount'=>$request['data']['amount'],'vat'=>'1','is_payed'=>$is_payed,'message'=>$request['data']['response']['message']];
            $response = Payment::firstOrCreate($data);
            return response()->json(['data'=>$response,'message'=>''],200);

        }catch (Exception $exception){
            return response()->json(['data'=>[],'message'=>$exception->getMessage()],$exception->getCode());

        }
    }
}
