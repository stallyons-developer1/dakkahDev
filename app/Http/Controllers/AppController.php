<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Favorites;
use App\Models\Follow;
use App\Models\Payment;
use App\Models\Rating;
use App\Models\Subscription;
use App\Models\User;
use App\Models\UserSubscription;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use DB;

class AppController extends Controller
{
    //
    public function index()
    {
        return view('layouts.front.default');
    }
    public function login(Request $request)
    {
        try {
            $request = $request->get('data');

            $validator = Validator::make($request,[
                'email' => 'required',
                'password' => 'required',
            ]);
            $result = User::where('email',$request['email'])->where('active','=','1')->first();
            if ($result && Hash::check($request['password'], $result['password'])){
                $checkSubscriptionDate = UserSubscription::where('user_id',$result['id'])->where('expire_date', '<=', Carbon::now()->toDateTimeString())->first();
                if ($checkSubscriptionDate){
                    session(['user_id'=>[$result['id']]]);
                    return response()->json(['data' => [] , 'message'=>'payment Required'],402);
                }else{
                    session(['user'=>['email'=>$result['email'],'user_id'=>$result['id'],'role_id'=>$result['group_id']]]);
                    //test start
                    if ($result['role_id'] === 2) {
                        $result = User::has('roles.rolePermission')->with('roles.rolePermission')->where('email',$request['email'])->where('active','=',1)->where('role_id','!=',3)->first();

                        if ($result && Hash::check($request['password'], $result['password'])){
                            $permissions = [];
                            if (isset($result->roles->rolePermission)){
                                $permissions = $result->roles->rolePermission->pluck('code');
                            }
                            session([
                                'user'=>[
                                    'email'   => $result['email'],
                                    'user_id' => $result['id'],
                                    'role_id' => $result['group_id'],
                                    'permissions' => $permissions , 
                                    'sdm' => $result['is_super_admin'],
                                    'avatar' => filled($result['image']) ? asset('images/users/'.$result['image']) : asset('assets/admin/dist/img/user2-160x160.jpg'),
                                ]
                            ]);

                            
                            return response()->json(['data' => ['role_id'=>$result['role_id']] , 'message'=>'Login Successfully'],200);    
                        }
                    }else if($result['role_id'] === 3){
                       // dd("3");
                        //return redirect(url('/trainers'));
                         return response()->json(['data' => ['role_id'=>$result['role_id']] , 'message'=>'Login Successfully'],200);    
                    }
                    //test end
                    
                }
            }
            if ($validator->fails()){
                return response()->json(['data' => [] , 'message'=>$validator->errors()->toArray()],422);

            }
            if ($result == null)
                return response()->json(['data' => [] , 'message'=>'email or password wrong'],500);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function register(Request $request)
    {
        $request = $request->get('data');
        $request['password'] = Hash::make($request['password']);
        $request['name'] = $request['first_name'];
        $request['username'] = strtok($request['email'], '@');
        $request['last_name'] = $request['first_name'];
        $request['description'] = $request['about_you'];

        $validator = Validator::make($request, [
            // 'name' => 'required',
            // 'username' => 'required',
            'first_name' => 'required',
            // 'last_name' => 'required',
            'phone' => ['required','unique:users'],
            'about_you'=>'',
            'role_id' => 'required',
            'gender' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if ($validator->fails()){
            return response()->json(['data' => [] , 'message'=>$validator->errors()->toArray()],422);

        }
        $request['active'] = 1;
        $result = User::create($request);
        if ($result){
            $this->storeSubscriptionUser($result);
            return response()->json(['data' => [] , 'message'=>'Register Successfully'],200);
        }

    }
    public function sendResetPasswordLink(Request $request){

        $validator = Validator::make($request->all(),['email' =>  'required|email']);

        if($validator->fails()) return response()->json([
            'data' => '',
            'message' => $validator->errors()->toArray()
        ], 422);

        $status = Password::sendResetLink($request->only('email'));

        if($status === Password::INVALID_USER )return response()->json(['message' => [ 'user' => [__($status)] ]], 422);

        return response()->json(['data' => $status,'message' => __($status)], 200);
    }
    public function resetPassword(Request $request){

        $validator = Validator::make($request->all(),[
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        if($validator->fails()) return response()->json([
            'data' => '',
            'message' => $validator->errors()->toArray()
        ], 422);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );

        if($status !== Password::PASSWORD_RESET )return response()->json(['message' => [ 'user' => [__($status)] ]], 422);

        return response()->json(['data' => $status,'message' => __($status)], 200);


    }
    public function profile(Request $request)
    {
        try{
            $profile = User::with('followers')->with('courses')->where('id', '=' , $request['id'])->first();
            return response()->json(['data' => $profile, 'message'=>'Login Successfully'],200);

        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);

        }
    }
    public function getTrainers(){
        try{
            $trainers = User::with('rating')->where('role_id','=','2')->where('active','=',1)->get()->toArray();
            return response()->json(['data' => $trainers, 'message'=>'Get Trainers Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);

        }
    }
    public function follow(Request $request)
    {
        try{
            if (!$request['is_follow']){
                $follow = 'Follow';
                $data = ['user_id'=>$request['user_id'],'trainer_id'=>$request['trainer_id']];
                $followers = Follow::create($data);
            }else{
                $follow = 'UnFollow';
                $followers = Follow::where('user_id',$request['user_id'])->where('trainer_id',$request['trainer_id'])->delete();
            }
            return response()->json(['data' => $followers, 'message'=>$follow. ' Trainers Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function getRating(Request $request){
        try{
            //check if already rating
            $user_id = session()->get('user') ? session()->get('user')['user_id']:null;
            $checkRating = Rating::where('trainer_id',$request['trainer_id']);
            if ($user_id)
                $checkRating = $checkRating->where('user_id',$user_id);

            $checkRating = $checkRating->count();
//
            $rating = Rating::where('trainer_id',$request['trainer_id'])->avg('rating');
           return response()->json(['data' => [$rating,$checkRating], 'message'=>' Rating Successfully '],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
   public function setRating(Request $request){
       try{
           $data = ['user_id'=>session()->get('user')['user_id'],'trainer_id'=>$request['trainer_id'],'rating'=>$request['rating']];
            $rating = Rating::create($data);
           return response()->json(['data' => $rating, 'message'=>' Rating Successfully '],200);
       }catch (Exception $exception){
           return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
       }
   }
    public function trainer_search(Request $request){
        try{
            $searchWord = $request['search'];
            $search = User::where('role_id','=',2);

            if ($request['city']){
                $search  = $search->where('city',$request['city']);
            }
            if ($searchWord){
                $search = $search->where('first_name','like','%'.$searchWord.'%')->orWhere('last_name','like','%'.$searchWord.'%');
            }
            $search = $search->where('role_id','=',2)->get()->toArray();
            
            return response()->json(['data' => $search , 'message'=>'Search Trainer Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function storeSubscriptionUser($data){
        try {
            $data=['user_id'=>$data['id'],'expire_date'=>Carbon::now()->addYears(1)->toDateTimeString()];
            $result = UserSubscription::create($data);
            if ($result)
                return response()->json(['data' => [] , 'message'=>'Register Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],$exception->getCode());

        }
    }
}
