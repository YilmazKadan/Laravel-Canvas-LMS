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

Route::get('/', function () {
    return view('index');
})->middleware("apimiddle");
Route::get('/anasayfa', function () {
    return view('index');
})->middleware("apimiddle");

Route::get('/giris', function () {
    return view('giris');
})->middleware("guestapi");



// Giriş işlemi ardından yönlenecek rooter.
Route::get('/oauth2response', "AuthController@responseAuth");
Route::get('/logout', "AuthController@logout")->name("logout");




Route::group(['middleware' => 'apimiddle'],function(){

//    Route::get("/profile","ApiController@profile")->name("profile");
//    Route::get("/users/account/{accountId}","UserApiController@users")->name("users");
//    Route::get("/adduser","UserApiController@index");
//    Route::post("/adduser","UserApiController@createUser")->name("adduser");
//    Route::get("/accounts","ApiController@accounts")->name('accounts');
//    Route::get("/course/enrollments/{id}","ApiController@enrollments");
//
//
//    Route::name("courses.")->prefix('courses/')->group(function(){
//        Route::get("/","CoursesController@index")->name("index");
//        Route::get("{courseId}","CoursesController@specific")->name("spesific");
//        Route::get("{courseId}/users","CoursesController@enrollments")->name("enrollments");
//    });
//

    Route::name("accounts.")->prefix('accounts')->group(function(){
        Route::get("/","AccountsController@index")->name("index");
        Route::get("{id}","AccountsController@specific")->name("spesific");
        Route::get("{id}/users","AccountsController@users")->name("users");
    });
});
