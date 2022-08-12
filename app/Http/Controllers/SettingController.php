<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    //
    public function update(Request $request){
        try{
            $setting = $request['setting'];
            $id = $setting['id'];
            unset($setting['id']);
            unset($setting['created_at']);
            unset($setting['updated_at']);
            $validator = Validator::make($setting, [
                'title' => 'required',
                'phone' => 'required',
                'email' => ['required', 'string', 'email', 'max:255'],
            ]);

            if ($validator->fails()){
                return response()->json(['error' => $validator->errors()->getMessages() , 'message'=>'Validation User Error'],422);
            }
            $result = Setting::where('id',$id)->update($setting);
           return response()->json(['data' => $result, 'message'=>' update setting Successfully '],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function edit(Request $request){
        try{
            $setting = Setting::find($request['id']);
           return response()->json(['data' => $setting, 'message'=> ' Setting list Successfully '],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
}
