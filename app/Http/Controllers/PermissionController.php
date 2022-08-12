<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    //
    public function list_permissions(Request $request){
        try {
//            dd($request->all);
            $list_permissions = Permission::paginate(10);
            if ($request->get('search') != null){
                $list_permissions = Permission::where('name','=' ,$request['search'])->paginate(10);
            }
            return response()->json(['data' => $list_permissions , 'message'=>'List Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function get_permissions(){
        try {
            $list_permissions = Permission::all();
            return response()->json(['data' => $list_permissions , 'message'=>'List Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function store(Request $request){
        try {
            $permissions = $request->all();
            $validator = Validator::make($permissions, [
                'name' => 'required',
            ]);
            if ($validator->fails()){
                return response()->json(['error' => $validator->errors() , 'message'=>'Validation Permission Error'],422);
            }
           $data = Permission::firstOrCreate($permissions);
            return response()->json(['data' => $data , 'message'=>'Create Permission Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function edit(Request $request){
        try {
            $permission = Permission::find($request->get("id"));
            return response()->json(['data' => $permission , 'message'=>'Edit Permission Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function update(Request $request){
        try {
            $permission = $request->all();
            $validator = Validator::make($permission, [
                'name' => 'required',
            ]);
            if ($validator->fails()){
                return ['error'=>$validator->errors()];
            }
            $update_response = Permission::where('id',$permission['id'])->update($permission);
            return response()->json(['data' => $update_response , 'message'=>'Update Permission Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function delete(Request $request){
        try {
            $delete_response = Permission::where('id',$request->get('id'))->delete();
            return response()->json(['data' => $delete_response , 'message'=>'Delete Permission Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
}
