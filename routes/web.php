<?php

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
    return view('welcome');
});
Route::options('api/{cors}',function(){
    return response('ok')
                         ->header('Access-Control-Allow-Methods','POST, GET, OPTIONS, PUT, DELETE')
                         ->header('Access-Control-Allow-Headers','Content-Type, X-Auth-Token, Origin');
})->middleware('cors');
Route::get('version/{friendCircle}', function(App\Models\FriendCircle $friendCircle) {
        dd($friendCircle);
    });