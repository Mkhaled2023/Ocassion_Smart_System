<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\ProductController;
use Illuminate\Auth\Events\Login;
use App\http\Controllers\imagesController;


Route::resource('product' , 'ProductController');
Route::post('login' , 'passportController@login');
Route::post('register' , 'passportController@register');
Route::put('update/{id}' , 'passportController@update');
Route::get("/product/{id}","productcontroller@show");
Route::get("user","passportController@details");
Route::post("upload",'imagesController@upload');
Route::get('getinfo/{id}','imagesController@getinfo');
Route::post('sendorganize','aboutorgainzeController@aboutOrganization');
Route::get('getinformation','aboutorgainzeController@getinformation');
Route::post("/Offer","offerController@Offerinsert");
Route::get("Offersshow","offerController@offershow");
Route::get("imagepro/{id}","offercontroller@getimagepro");
Route::post("comment","CommentsController@comment");
Route::post("event","EventController@events");
Route::get("showcomment","CommentsController@showcomments");
//Route::middleware('auth:api')->get('/user', function (Request $request) {
Route::get("getcat","EventController@getcat");

Route::get("getcatdeatils","EventController@getcatdeatils");
Route::get("getinformation/{name}","ProductController@getinformation");

Route::post("review_halls","ProductController@review_halls");
Route::get("getreviewhalls/{id}","ProductController@getreviewhalls");
Route::post("/offerreview","offerController@offerreview");
Route::get("getofferreview/{id}","offerController@getofferreview");
Route::get("getioffer/{id}","offerController@getoffers");
Route::post("deal","offerController@deal");

//});
