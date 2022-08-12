<?php

namespace App\Http\Controllers;

use App\Models\Categories;
// use App\Models\RolePermission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //
    public function list_categories(Request $request){
        try {
            $list_categories = Categories::paginate(10);
            if ($request->get('search') != null){
                $list_categories = Categories::where('category_en','=' ,$request['search'])->paginate(10);
            }

            return response()->json(['data' => $list_categories , 'message'=>'List Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function get_categories(){
        try {
            $list_categories = Categories::all();
            return response()->json(['data' => $list_categories , 'message'=>'List Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function store(Request $request){
        try {
            $categories = $request->all();
            $validator = Validator::make($categories, [
                'category_ar' => 'required',
                'category_en' => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['error' => $validator->errors() , 'message'=>'Validation Categories Error'],422);
            }

            $data = Categories::firstOrCreate($categories);

            return response()->json(['data' => $data , 'message'=>'Create Categories Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function edit(Request $request){
        
        try {
            $categories = Categories::where('category_id',$request->get("category_id"))->first();
            return response()->json(['data' => $categories , 'message'=>'Edit Categories Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function update(Request $request){
        try {
            $categories = $request->all();
            $validator = Validator::make($categories, [
                'category_en' => 'required',
                'category_ar' => 'required',
            ]);
            if ($validator->fails()){
                return ['error'=>$validator->errors()];
            }

            $update_response = Categories::where('category_id',$categories['category_id'])->update($categories);

            return response()->json(['data' => $update_response , 'message'=>'Update Categories Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function delete(Request $request){
        try {
            $delete_response = Categories::where('category_id',$request->get('category_id'))->delete();
            return response()->json(['data' => $delete_response , 'message'=>'Delete Categories Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
}
