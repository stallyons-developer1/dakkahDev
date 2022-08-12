<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //LOGIN FUNCTIONS //
    public function dashboard(){
        return view('layouts.admin.default');
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);
        $result = User::has('roles.rolePermission')->with('roles.rolePermission')->where('email',$request->get('email'))->where('active','=',1)->where('role_id','!=',3)->first();

        if ($result && Hash::check($request->input('password'), $result['password'])){
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
            return redirect(url('/admin/courses'));
        }
        return redirect()->back()->withErrors($validator)->withInput();
    }
    public function logout(){
        session()->flush();
        return redirect('/login');
    }

    public function logout_front(){
        session()->flush();
        return redirect('/');
    }
    // API FUNCTIONS //
    public function list_users(Request $request){
        try {
            $list_user = User::with('roles')->paginate(10);
            if ($request->get('search') != null){
                $list_user = User::with('roles')->where('first_name','like' ,'%' .$request['search'].'%')
                    ->orWhere('last_name','like' , '%' . $request['search'] . '%')
                    ->orWhere('email','like' , '%' . $request['search'] . '&')
                    ->paginate(10);
            }
            return response()->json(['data' => $list_user , 'message'=>'List Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function upload_user_image(Request $request){
        $imageName = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('images/users'), $imageName);
        return $imageName;
    }
    public function upload_background_image(Request $request){
        $imageName = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('images/users'), $imageName);
        return $imageName;
    }
    public function store(Request $request){
        try {
            $users = $request->all();
            $users['active'] = $users['active'] ? '1':'0';
            $users['password'] = Hash::make($users['password']);
            $validator = Validator::make($users, [
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => ['required','unique:users'],
                'about_you' => '',
                'role_id' => 'required',
                'gender' => 'required',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'image_user' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'background_image' => '',
            ]);

            if ($validator->fails()){
                return response()->json(['error' => $validator->errors() , 'message'=>'Validation User Error'],422);
            }
            $data = User::firstOrCreate($users);
            return response()->json(['data' => $data , 'message'=>'Create User Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function edit(Request $request){
        try {
            $user = User::find($request->get("id"));
            return response()->json(['data' => $user , 'message'=>'Edit User Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function update(Request $request , User $user){
        try {
            $user = User::find($request['id']);
//            dd($user['id']);
            $users = $request->all();
            $users['active'] = $users['active'] ? '1':'0';

            if(isset($users['password']))
                $users['password'] = $users['password'] ? Hash::make($users['password']): '';



            $validator = Validator::make($users, [
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'role_id' => 'required',
                'about_you' => '',
                'gender' => 'required',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user['id']],
                'password' => ['sometimes','required', 'string', 'min:8'],
                'image_user' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'background_image' => '',
            ]);

            if ($validator->fails()){
                return ['error'=>$validator->errors()];
            }
//            dd($users);

            $update_response = User::where('id',$users['id'])->update($users);

            return response()->json(['data' => $update_response , 'message'=>'Update User Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function delete(Request $request){
        try {
            $delete_response = User::where('id',$request->get('id'))->delete();
            return response()->json(['data' => $delete_response , 'message'=>'Delete User Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
}
