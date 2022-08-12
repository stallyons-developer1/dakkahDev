<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    //
    public function list_contact(Request $request){
        try{
            $contacts = Contact::paginate(10);
            return response()->json(['data' => $contacts , 'message'=>'List contact Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);

        }
    }
    public function store(Request $request){
        try {
            $data = $request['dataForm'];
//            dd($data);
            $validator = Validator::make($data, [
                'name' => 'required',
//                'message' => 'required',
                // 'recaptcha' => 'required|captcha',
                'title' => 'required',
                'email' => ['required', 'string', 'email'],
            ]);
            if ($validator->fails()){
                return response()->json(['data' => $validator->errors()->toArray() , 'message'=>'validation error' ],422);

            }
            $result = Contact::create($data);
            if ($result)
                return response()->json(['data' => [] , 'message'=>'Register Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);

        }
    }
    public function delete(Request $request){
        try {
            $delete_response = Contact::where('id',$request->get('id'))->delete();
            return response()->json(['data' => $delete_response , 'message'=>'Delete Contact Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
}
