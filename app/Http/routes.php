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

Route::get('/bulletin', function () {
    return view('bulletin/index');
});
<<<<<<< HEAD


=======
<<<<<<< HEAD


=======
>>>>>>> a15eb863e53829e0b2906a653cadd04f30663d66
>>>>>>> 2122ce65bcb88e274b35a1b6670bd7a117a259ea
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
  
  Route::get('group','GroupController@index');
  Route::get('group/{id}', 'GroupController@show');
  
  Route::get('archive/{id}', 'GroupController@archive');
  
  Route::get('addgroup','AddGroupController@index');
  Route::post('addgroup', 'AddGroupController@add');
  
  Route::get('questionbank','QuestionBankController@index');
<<<<<<< HEAD
  Route::get('formquestion','FormQuestionController@index');
  
  Route::get('createquiz/{id}', 'FormExamController@create');
  Route::post('formexam', 'FormExamController@form');
  
  Route::get('viewexam/{id}', 'FormExamController@view');
  Route::post('viewexam', 'FormExamController@view');
  
  Route::post('getresult', 'CheckAnswerController@check');
  
  Route::get('deleteexam/{group_id}/{exam_id}', 'FormExamController@delete');
  
  Route::get('editquestion/{id}', 'FormQuestionController@edit');
  Route::get('editquestion/{id}/delete', 'FormQuestionController@delete');
  Route::post('formquestion', 'FormQuestionController@form');
  
=======
>>>>>>> 2122ce65bcb88e274b35a1b6670bd7a117a259ea
  Route::get('calendar','CalendarController@index');
  Route::get('help','sendmail@index');
  Route::post('help', 'sendmail@send');
  Route::get('mailtest', function() {
    return view('mail');
<<<<<<< HEAD
    
=======
>>>>>>> 2122ce65bcb88e274b35a1b6670bd7a117a259ea
  });
//   Route::get('/calendar', function () {
//     return view('calendar');  
//   });
 /* 
  [
     'middleware' => ['auth', 'roles'], //use the roles middleware
     'uses' => 'HomeController@index',
     'roles' => ['admin', 'client'] // only admin and client roles are allowed
]);
*/
});



    
