<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    //
    public function newCourseEmail(){
        $user_id = session()->get('user')['user_id'];
        $subscriptions = Follow::select('user_id')->where('trainer_id',$user_id)->get()->pluck('user_id')->toArray();
        $emails = User::whereIn('id',$subscriptions)->get()->pluck('email')->toArray();
        $details = [
            'title' => 'New Course',
            'body' => 'This is for testing email using smtp',
            'url' => 'www.test.com'
        ];
        \Mail::to($emails)->send(new \App\Mail\NewCourse($details));
        dd("Email is Sent.");
    }

}
