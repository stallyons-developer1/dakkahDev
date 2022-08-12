<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    //front end function
    public function get_courses(Request $request){
        try {
            $user_id = session()->get('user') ?session()->get('user')['user_id']:null;
            $list_courses = Course::with('users')->with('favorites')->where('active','=','1')->orderBy('created_at',"DESC");
            if (isset($request['limit']))
                $list_courses = $list_courses->limit(8);
            if (isset($request['random']))
                $list_courses = !$list_courses->isEmpty() ? $list_courses->random(4):[];
            if (isset($request['user_id']))
                $list_courses = $list_courses->where('created_by',$request['user_id']);
//            else if ($user_id)
//                $list_courses = $list_courses->where('created_by',$user_id);

            $list_courses = $list_courses->get()->toArray();
            return response()->json(['data' => $list_courses , 'message'=>'List Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function get_single_course(Request $request){
        try {
            $single_course = Course::with('users')->with('favorites')->find($request->input('id'));
            $user_details = User::find($single_course['created_by']);
            return response()->json(['data' => $single_course ,'data2' => $user_details , 'message'=>'List Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }

    //back end functions
    public function list_courses(Request $request){
        try {
            $is_super_admin = session()->get('user')['sdm'];
            $list_courses = new Course();
            if(!$is_super_admin){
                $list_courses = $list_courses->where('created_by','=',session()->get('user')['user_id']);
            }
            $list_courses = $list_courses->paginate(10);

            if ($request->get('search') != null){
                $list_courses = Course::where('title','=' ,$request['search'])->paginate(10);
            }
            return response()->json(['data' => $list_courses , 'message'=>'List Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function upload_course_image(Request $request){
        $imageName = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('images/courses'), $imageName);
        return $imageName;
    }
    public function store(Request $request){
        try {
            $courses = $request->all();
            //$courses['category'] = implode(',', $courses['category']);
            $courses['active'] = $courses['active'] ? '1':'0';
            $courses['created_by'] = session()->get('user') ?session()->get('user')['user_id']:null ;
            $validator = Validator::make($courses, [
                'title' => 'required',
            ]);

            if ($validator->fails()){
                return response()->json(['error' => $validator->errors() , 'message'=>'Validation User Error'],422);
            }
            $data = Course::firstOrCreate($courses);
            return response()->json(['data' => $data , 'message'=>'Create Course Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function edit(Request $request){
        try {
            $user = Course::find($request->get("id"));
            return response()->json(['data' => $user , 'message'=>'Edit Course Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function update(Request $request){
        try {
            $courses = $request->all();
           // $courses['category'] = implode(',', $courses['category']);
            $courses['active'] = $courses['active'] ? '1':'0';
            $validator = Validator::make($courses, [
                'title' => 'required',
            ]);

            if ($validator->fails()){
                return ['error'=>$validator->errors()];
            }

            $update_response = Course::where('id',$courses['id'])->update($courses);

            return response()->json(['data' => $update_response , 'message'=>'Update Course Successfully'],200);
        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function delete(Request $request){
        try {
            $delete_response = Course::where('id',$request->get('id'))->delete();
            return response()->json(['data' => $delete_response , 'message'=>'Delete Course Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function generateRandomLink(){
        try {
            $randomLink = env('REGISTRATION_LINK') . Str::random(100);
            return response()->json(['data' => $randomLink , 'message'=>'Delete Course Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function search(Request $request){
        try{
            $searchWord = $request['search'];
            $search  = Course::with('users')->with('favorites');

            if ($request['city']){
                $search  = $search->where('city',$request['city']);

            }
            if ($request['category']){
                $search  = $search->whereRaw("find_in_set('".$request['category']."' , category)");
            }
            if ($searchWord){
                $search = $search->where('title','like','%'.$searchWord.'%')->orWhere('description','like','%'.$searchWord.'%');
            }
            $search = $search->get();
            return response()->json(['data' => $search , 'message'=>'Search Course Successfully'],200);

        }catch (Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);

        }
    }
    public function get_my_courses(Request $request){
        try {
            $user_id = $request->get('id');
            $myCourses = Course::whereHas('subscriptions', function($q) use($user_id)
            {
                $q->where('user_id','=', $user_id)->where('subscription_type','free')->where( 'created_at', '<=', Carbon::now()->subDays(15))->orWhere('subscription_type','yearly');
            })->get();
            return response()->json(['data' => $myCourses , 'message'=>'List Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
    public function get_categories(){
        try {
            //$cat =[];
            $categories = Course::select('category')->orderBy('created_by')->get()->pluck('category')->toArray();
            // foreach ($categories as $category){
            //     $cat[] = explode(',', $category);
            // }
            // $cat = Arr::flatten($cat);
            return response()->json(['data' => $categories , 'message'=>'List Return Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    }
}
