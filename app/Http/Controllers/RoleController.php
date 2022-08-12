<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function list_roles(Request $request){
        try {
            $list_roles = Role::with('permission')->paginate(10);
            if ($request->get('search') != null){
                $list_roles = Role::where('name','=' ,$request['search'])->paginate(10);
            }
            return response()->json(['data' => $list_roles , 'message'=>'List Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function get_roles(){
        try {
            $list_roles = Role::all();
            return response()->json(['data' => $list_roles , 'message'=>'List Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function store(Request $request){
        try {
            $roles = $request->all();
            $validator = Validator::make($roles, [
                'name' => 'required',
                'permission_id' => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['error' => $validator->errors() , 'message'=>'Validation Role Error'],422);
            }

            $permission_id = $request->get("permission_id");
            $permission_id = explode(",",$permission_id);
            unset($roles['permission_id']);

            $data = Role::firstOrCreate($roles);

            if ($data){
                $permission_role = Role::findOrFail($data['id']);
                $permission_role->permission()->attach($permission_id);
            }

            return response()->json(['data' => $data , 'message'=>'Create Role Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function edit(Request $request){
        try {
            $role = Role::with('permission')->find($request->get("id"));
            return response()->json(['data' => $role , 'message'=>'Edit Role Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function update(Request $request){
        try {
            $roles = $request->all();
            $validator = Validator::make($roles, [
                'name' => 'required',
                'permission_id' => 'required',
            ]);
            if ($validator->fails()){
                return ['error'=>$validator->errors()];
            }
            $permission_id = $request->get("permission_id");
            $permission_id = explode(",",$permission_id);
            unset($roles["permission_id"]);

            $update_response = Role::where('id',$roles['id'])->update($roles);
            //update relation with permission
            $update_relation = Role::findOrFail($roles['id'])->permission()->sync($permission_id);

            return response()->json(['data' => $update_response , 'message'=>'Update Role Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function delete(Request $request){
        try {
            $delete_relation = Role::findOrFail($request->get('id'))->permission()->detach();
            $delete_response = Role::where('id',$request->get('id'))->delete();
            return response()->json(['data' => $delete_response , 'message'=>'Delete Role Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
}
