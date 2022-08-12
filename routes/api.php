<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//BEGIN FRONT END API //
//courses
Route::post('/courses/get_courses',[\App\Http\Controllers\CourseController::class, 'get_courses']);
Route::post('/courses/get_random_courses',[\App\Http\Controllers\CourseController::class, 'get_courses']);
Route::post('/courses/get_single_course',[\App\Http\Controllers\CourseController::class, 'get_single_course']);
Route::post('/courses/get_my_courses',[\App\Http\Controllers\CourseController::class, 'get_my_courses']);
Route::post('/courses/search',[\App\Http\Controllers\CourseController::class, 'search']);
Route::post('/trainer/search',[\App\Http\Controllers\AppController::class, 'trainer_search']);

//subscription
Route::post('/subscriptionCourse',[\App\Http\Controllers\SubscriptionController::class, 'subscriptionCourse']);
Route::post('/payment_subscriptions/',[\App\Http\Controllers\SubscriptionController::class, 'store']);
Route::post('payment-process', [\App\Http\Controllers\StripePaymentController::class, 'process']);
Route::post('payment/charges', [\App\Http\Controllers\PaymentController::class, 'createChargers']);
Route::post('payment/store', [\App\Http\Controllers\PaymentController::class, 'store']);
Route::post('payment/getCharges', [\App\Http\Controllers\PaymentController::class, 'getChargers']);
//profiles
Route::post('profile', [\App\Http\Controllers\AppController::class, 'profile']);
//trainer
Route::post('trainers', [\App\Http\Controllers\AppController::class, 'getTrainers']);
Route::post('follow/trainer', [\App\Http\Controllers\AppController::class, 'follow']);
//contacts us
Route::post('/contacts/store', [\App\Http\Controllers\ContactController::class, 'store']);
//auth
Route::post('/auth/registertrainee',[\App\Http\Controllers\AppController::class, 'register']);
Route::post('/auth/register',[\App\Http\Controllers\AppController::class, 'register']);
Route::post('/auth/login',[\App\Http\Controllers\AppController::class, 'login']);
Route::post('/auth/forget-password-link',[\App\Http\Controllers\AppController::class, 'sendResetPasswordLink'])->middleware('guest');
Route::post('/auth/reset-password',[\App\Http\Controllers\AppController::class, 'resetPassword'])->middleware('guest');

//favorite
Route::post('favorite', [\App\Http\Controllers\FavoriteController::class, 'favorites']);
Route::post('favorites/myFavorites', [\App\Http\Controllers\FavoriteController::class, 'myFavorites']);
//rating
Route::post('rating/getRating', [\App\Http\Controllers\AppController::class, 'getRating']);
Route::post('rating/setRating', [\App\Http\Controllers\AppController::class, 'setRating']);

//category
//Route::post('category', [\App\Http\Controllers\CourseController::class, 'get_categories']);
Route::get('/category',function(){
        try {
            $categories = \Illuminate\Support\Facades\DB::table('categories')->whereNull('deleted_at')->get()->toArray();
            return response()->json(['data' => $categories , 'message'=>'list categories Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    });

//END FRONT END API //

Route::prefix('admin')->group(function () {
    //Begin Permissions API //
    Route::post('/permissions/list',[\App\Http\Controllers\PermissionController::class, 'list_permissions']);
    Route::get('/permissions/get_permissions',[\App\Http\Controllers\PermissionController::class, 'get_permissions']);
    Route::post('/permissions/add',[\App\Http\Controllers\PermissionController::class, 'store']);
    Route::post('/permissions/update',[\App\Http\Controllers\PermissionController::class, 'update']);
    Route::post('/permissions/edit',[\App\Http\Controllers\PermissionController::class, 'edit']);
    Route::post('/permissions/delete',[\App\Http\Controllers\PermissionController::class, 'delete']);
    //END Permissions API //

    //Begin Roles API //
    Route::post('/roles/list',[\App\Http\Controllers\RoleController::class, 'list_roles']);
    Route::get('/roles/get_roles',[\App\Http\Controllers\RoleController::class, 'get_roles']);
    Route::post('/roles/add',[\App\Http\Controllers\RoleController::class, 'store']);
    Route::post('/roles/update',[\App\Http\Controllers\RoleController::class, 'update']);
    Route::post('/roles/edit',[\App\Http\Controllers\RoleController::class, 'edit']);
    Route::post('/roles/delete',[\App\Http\Controllers\RoleController::class, 'delete']);
    //END Roles API //

    //Begin Categories API //
    Route::post('/categories/list',[\App\Http\Controllers\CategoriesController::class, 'list_categories']);
    Route::get('/categories/get_categories',[\App\Http\Controllers\CategoriesController::class, 'get_categories']);
    Route::post('/categories/add',[\App\Http\Controllers\CategoriesController::class, 'store']);
    Route::post('/categories/update',[\App\Http\Controllers\CategoriesController::class, 'update']);
    Route::post('/categories/edit',[\App\Http\Controllers\CategoriesController::class, 'edit']);
    Route::post('/categories/delete',[\App\Http\Controllers\CategoriesController::class, 'delete']);
    //END Categories API //

    //Begin Cities API //
    Route::post('/cities/list',[\App\Http\Controllers\CitiesController::class, 'list_cities']);
    Route::get('/cities/get_cities',[\App\Http\Controllers\CitiesController::class, 'get_cities']);
    Route::post('/cities/add',[\App\Http\Controllers\CitiesController::class, 'store']);
    Route::post('/cities/update',[\App\Http\Controllers\CitiesController::class, 'update']);
    Route::post('/cities/edit',[\App\Http\Controllers\CitiesController::class, 'edit']);
    Route::post('/cities/delete',[\App\Http\Controllers\CitiesController::class, 'delete']);
    //END Cities API //


    //Begin Users API //
    Route::post('/users/list',[\App\Http\Controllers\UserController::class, 'list_users']);
    Route::post('/users/upload_image',[\App\Http\Controllers\UserController::class, 'upload_user_image']);
    Route::post('/users/upload_background_image',[\App\Http\Controllers\UserController::class, 'upload_background_image']);
    Route::post('/users/add',[\App\Http\Controllers\UserController::class, 'store']);
    Route::post('/users/update',[\App\Http\Controllers\UserController::class, 'update']);
    Route::post('/users/edit',[\App\Http\Controllers\UserController::class, 'edit']);
    Route::post('/users/delete',[\App\Http\Controllers\UserController::class, 'delete']);
    //END Users API //

    //Begin Courses API //
    Route::post('/courses/list',[\App\Http\Controllers\CourseController::class, 'list_courses']);
    Route::post('/courses/upload_image',[\App\Http\Controllers\CourseController::class, 'upload_course_image']);
    Route::post('/courses/add',[\App\Http\Controllers\CourseController::class, 'store']);
    Route::post('/courses/update',[\App\Http\Controllers\CourseController::class, 'update']);
    Route::post('/courses/edit',[\App\Http\Controllers\CourseController::class, 'edit']);
    Route::post('/courses/delete',[\App\Http\Controllers\CourseController::class, 'delete']);
    Route::get('/courses/generateRandomLink',[\App\Http\Controllers\CourseController::class, 'generateRandomLink']);
    //END courses API //


    //Begin Contacts API //
    Route::post('/contacts/list', [\App\Http\Controllers\ContactController::class, 'list_contact']);
    Route::post('/contacts/delete', [\App\Http\Controllers\ContactController::class, 'delete']);
    //END Contacts API //

    //Begin Setting API //
    Route::post('/settings/edit', [\App\Http\Controllers\SettingController::class, 'edit']);
    Route::post('/settings/update', [\App\Http\Controllers\SettingController::class, 'update']);
    //END Setting API //

    //Begin Email API //
    Route::post('/newCourseEmail', [\App\Http\Controllers\EmailController::class, 'newCourseEmail']);
    //END Email API //

    Route::get('/cities/list',function(){
        try {
            $cities = \Illuminate\Support\Facades\DB::table('cities')->whereNull('deleted_at')->get()->toArray();
            return response()->json(['data' => $cities , 'message'=>'list cities Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    });
    Route::get('/categories/list',function(){
        try {
            $categories = \Illuminate\Support\Facades\DB::table('categories')->whereNull('deleted_at')->get()->toArray();
            return response()->json(['data' => $categories , 'message'=>'list categories Successfully'],200);
        }catch(Exception $exception){
            return response()->json(['data' => [] , 'message'=>$exception->getMessage()],500);
        }
    });

});
