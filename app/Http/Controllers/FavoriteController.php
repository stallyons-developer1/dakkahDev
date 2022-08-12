<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Favorites;
use http\Exception;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    //
    public function favorites(Request $request){
        try{
            if (!$request['is_favorite']){
                $favorite = 'Favorite';
                $data = ['user_id'=>$request['user_id'],'course_id'=>$request['course_id']];
                $favorites = Favorites::create($data);
            }else{
                $favorite = 'UnFavorite';
                $favorites = Favorites::where('user_id',$request['user_id'])->where('course_id',$request['course_id'])->delete();
            }
            return response()->json(['data' => $favorites, 'message'=>$favorite. ' Course Successfully '],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function myFavorites(Request $request){
        try{
            $user_id = $request['user_id'];
//            $favorites = Favorites::has('courses')->with('courses')->where('user_id',$request['user_id'])->get();
//            $favorites = $favorites->pluck('courses');
            $coursesFavorites = Course::with('users')->whereHas('favorites', function($q) use($user_id) {
                $q->where('user_id', '=', $user_id); // '=' is optional
            })->get()->toArray();
            return response()->json(['data' => $coursesFavorites, 'message'=>'List Course Successfully '],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
}
