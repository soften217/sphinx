<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
Route::get('/', function () { if(DB::connection()->getDatabaseName()) { echo "Yes! successfully connected to the DB: " . DB::connection()->getDatabaseName(); } });
*/
Route::get('/', function () {
    return view('welcome');
});
    

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
  Route::auth(); // must be inside 'web'
  Route::get('home','HomeController@index');
 /* 
  [
     'middleware' => ['auth', 'roles'], //use the roles middleware
     'uses' => 'HomeController@index',
     'roles' => ['admin', 'client'] // only admin and client roles are allowed
]);
*/
});


    
