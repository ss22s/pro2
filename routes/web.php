<?php

use Illuminate\Support\Facades\Route;

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

//処理なし
// Route::get('/', function () {
//     return view('top');
// });
Route::get('/reserveFinish',function(){
    return view('/reserveFinish');
});
Route::get('/newRegister',function(){
    return view('newRegister');
});
Route::get('/index', function () {//テスト追加
    return view('index');
});


//処理有
Route::get('/','App\Http\Controllers\TopController@toppage');
Route::post('/','App\Http\Controllers\TopController@toppage');

// Route::post('/newRegister','App\Http\Controllers\VaccineController@newRegister');
// Route::get('/newRegister','App\Http\Controllers\VaccineController@newRegister');

// Route::post('/newReserve','App\Http\Controllers\VaccineController@login');
// Route::post('/login','App\Http\Controllers\VaccineController@login');

// Route::post('/selectPlace','App\Http\Controllers\VaccineController@checkuser');
// Route::post('/mypage','App\Http\Controllers\Vaccinecontroller@checkuser');
// Route::get('/selectPlace','App\Http\Controllers\VaccineController@place');
// Route::post('/selectDay','App\Http\Controllers\Vaccinecontroller@day');

Route::get('/selectTime','App\Http\Controllers\Vaccinecontroller@Time');
Route::post('/selectTime','App\Http\Controllers\Vaccinecontroller@Time');
Route::get('/reserveConfirm','App\Http\Controllers\Vaccinecontroller@Confirm');
Route::post('/reserveConfirm','App\Http\Controllers\Vaccinecontroller@Confirm');
// Route::post('/mypage','App\Http\Controllers\Vaccinecontroller@mypage');

//delete関連
Route::post('/mypageD','App\Http\Controllers\mypageController@display');
Route::post('/delete','App\Http\Controllers\dataController@delete');

//change関連
Route::post('/mypageC','App\Http\Controllers\mypageController@display');
Route::post('/changeConfirm','App\Http\Controllers\mypageController@confirm');
Route::post('/change','App\Http\Controllers\dataController@change');

Route::get('/break','App\Http\Controllers\dataController@break');


//処理のみ
Route::post('/register', 'App\Http\Controllers\VaccineController@register');
Route::get('/top','App\Http\Controllers\VaccineController@resRegister');
Route::post('/top','App\Http\Controllers\VaccineController@resRegister');


//テスト
Route::get('session','App\Http\Controllers\VaccineController@ses_get');
Route::post('session','App\Http\Controllers\VaccineController@ses_put');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logout','App\Http\Controllers\Auth\LoginController@logout');
