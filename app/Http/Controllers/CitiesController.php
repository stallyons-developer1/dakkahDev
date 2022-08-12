<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    //
    public function list_cities(Request $request){
        try {
            $list_cities = Cities::paginate(10);
            if ($request->get('search') != null){
                $list_cities = Cities::where('name_en','=' ,$request['search'])->paginate(10);
            }
            return response()->json(['data' => $list_cities , 'message'=>'List Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function get_cities(){        
        try {
            $list_cities = Cities::all();
            return response()->json(['data' => $list_cities , 'message'=>'List Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function store(Request $request){
        try {
            $cities = $request->all();
            $validator = Validator::make($cities, [
                'name_ar' => 'required',
                'name_en' => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['error' => $validator->errors() , 'message'=>'Validation Cities Error'],422);
            }

            $data = Cities::firstOrCreate($cities);

            return response()->json(['data' => $data , 'message'=>'Create Cities Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function edit(Request $request){
        try {
            $cities = Cities::where('city_id',$request->get("city_id"))->first();
            return response()->json(['data' => $cities , 'message'=>'Edit Cities Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function update(Request $request){
        try {
            $cities = $request->all();
            $validator = Validator::make($cities, [
                'name_en' => 'required',
                'name_ar' => 'required',
            ]);
            if ($validator->fails()){
                return ['error'=>$validator->errors()];
            }

            $update_response = Cities::where('city_id',$cities['city_id'])->update($cities);

            return response()->json(['data' => $update_response , 'message'=>'Update Cities Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function delete(Request $request){
        try {
            $delete_response = Cities::where('city_id',$request->get('city_id'))->delete();
            return response()->json(['data' => $delete_response , 'message'=>'Delete Cities Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
}
