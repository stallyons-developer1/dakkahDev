<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    //
    public function list_sub(){

    }
    public function store(Request $request){
        try {
            $data =$request['subscription'];
            $user_id = session()->get('user') ? session()->get('user')['user_id']:0;
            $data['user_id'] = $user_id;
            $data = Subscription::create($data);
            return response()->json(['data' => $data , 'message'=>'Create Subscription Successfully'],200);

        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function subscriptionCourse(Request $request){
        try {
            $data = $request->all();
            $data['subscription_type'] = 'free';
            $user_id = session()->get('user') ? session()->get('user')['user_id']:0;
            $data['user_id'] = $user_id;
            //check if exist subscription
            $subscription = Subscription::where('user_id', $user_id)->where('course_id',$data['course_id'])->exists();
            if ($subscription)
                Subscription::where('user_id', $user_id)->where('course_id',$data['course_id'])->delete();

            $data = Subscription::create($data);
            return response()->json(['data' => $data , 'message'=>'Create Subscription Successfully'],200);

        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
}
