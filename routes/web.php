<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('locale/{locale}',function ($locate){
    Session::put('locale',$locate);
    return redirect()->back();
});
//Route::get('/payment', [\App\Http\Controllers\StripePaymentController::class, 'index']);
Route::get('/test',function (){
//    $charges = [
//        'amount'=>100,'currency'=>'SAR','customer'=>
//            ["first_name"=> "test",
//                "middle_name"=> "test",
//                "last_name"=> "test",
//                "email"=> "test@test.com"],
//        "source"=>["id"=>'tok_V63h1999211640qPN229nA7k280'] ,
//        "post"=>["url"=>"http://127.0.0.1:8000/post_url"],
//        "redirect"=>["url"=> "http://127.0.0.1:8000/redirect_url"],
//        "phone"=> [ "country_code"=>"965","number"=>"50000000"]
//    ];
//    $response = Http::withHeaders(
//        ['Authorization' => 'Bearer '.env('TABE_SECRIT_KEY')]
//    )->post(env('TABE_URL'), $charges);
//    dd($response->json() , json_encode($charges));
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.tap.company/v2/charges",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{\"amount\":1,\"currency\":\"KWD\",\"threeDSecure\":true,\"save_card\":false,\"description\":\"Test Description\",\"statement_descriptor\":\"Sample\",\"metadata\":{\"udf1\":\"test 1\",\"udf2\":\"test 2\"},\"reference\":{\"transaction\":\"txn_0001\",\"order\":\"ord_0001\"},\"receipt\":{\"email\":false,\"sms\":true},\"customer\":{\"first_name\":\"test\",\"middle_name\":\"test\",\"last_name\":\"test\",\"email\":\"test@test.com\",\"phone\":{\"country_code\":\"965\",\"number\":\"50000000\"}},\"merchant\":{\"id\":\"\"},\"source\":{\"id\":\"src_sa.mada\"},\"post\":{\"url\":\"http://your_website.com/post_url\"},\"redirect\":{\"url\":\"http://your_website.com/redirect_url\"}}",
        CURLOPT_HTTPHEADER => array(
            "authorization: Bearer sk_test_XKokBfNWv6FIYuTMg5sLPjhJ",
            "content-type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
});
//admin
Route::get('/login', function () {
    return view('auth.Login');
});
Route::get('/logout',[UserController::class, 'logout']);
Route::get('/logout_front',[UserController::class, 'logout_front']);
Route::post('/login',[UserController::class, 'login']);
Route::prefix('admin')->middleware(['CheckLogin'])->group(function () {
    Route::get('/{any}',[UserController::class, 'dashboard'])->where('any', '.*');;

});

//front
Route::get('/{any}',[AppController::class, 'index'])->where('any', '.*');;



