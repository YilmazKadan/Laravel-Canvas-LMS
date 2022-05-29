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

   Route::get("/profile","GeneralController@profile")->name("profile");

    Route::resource("courses","CoursesController")->except([
        "show",
        "crate",
        "edit"
    ]);
//   Accounts
    Route::name("accounts.")->prefix('accounts')->group(function(){
        Route::get("/","AccountsController@index")->name("index");
        Route::get("{id}","AccountsController@specific")->name("spesific");

        Route::resource("{id}/users","AccountsUserController");
        Route::resource("{id}/donemler","AccountsTermsController");
    });
// Courses
    Route::name("courses.")->prefix("courses")->group(function(){

        Route::get("/","CoursesController@index")->name("index");
        Route::get("{id}","CoursesController@spesific")->name("spesific");
        Route::get("{id}/publish","CoursesController@publish")->name("publish");
        Route::get("{id}/unpublish","CoursesController@unpublish")->name("unpublish");

        Route::resource("{id}/enrollments","CourseEnrollmentsController");
    });
});
