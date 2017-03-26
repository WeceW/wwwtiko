<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/my-account/edit/{user}', 'AccountController@edit');
Route::post('/my-account/edit/{user}', 'AccountController@update');
Route::post('/my-account/delete/{user}', 'AccountController@destroy');
Route::get('/my-account', 'AccountController@index');

Route::post('/session/start/{tasklist_id}', 'SessionsController@startSession');
Route::get('/session/{session_id}/summary', 'SessionsController@summary');
Route::get('/session/{session_id}/{task}', 'SessionsController@showTask');
Route::get('/session/{session_id}/{task}/feedback', 'SessionsController@feedback');
Route::post('/session/{session_id}/{task}/save', 'SessionsController@saveAttempt');

Route::group(['middleware' => ['admin']], function() { 
    Route::get('/users', 'UsersController@index');
    Route::get('/users/edit/{user}', 'UsersController@edit');
    Route::post('/users/edit/{user}', 'UsersController@update');
    Route::post('/users/delete/{user}', 'UsersController@destroy');
});

Route::group(['middleware' => ['teacher']], function() { 
    Route::get('/tasks/create', 'TasksController@create');
    Route::post('/tasks/create', 'TasksController@store');
    Route::get('/tasks/edit/{task}', 'TasksController@edit');
    Route::post('/tasks/edit/{task}', 'TasksController@update');
    Route::post('/tasks/delete/{task}', 'TasksController@destroy');
    Route::get('/tasks', 'TasksController@index');

    Route::get('/tasklists/create', 'TasklistsController@create');
    Route::post('/tasklists/create', 'TasklistsController@store');
    Route::get('/tasklists/edit/{tasklist}', 'TasklistsController@edit');
    Route::post('/tasklists/edit/{tasklist}', 'TasklistsController@update');
    Route::post('/tasklists/delete/{tasklist}', 'TasklistsController@destroy');
    Route::get('/tasklists', 'TasklistsController@index');
});

Route::auth();

Route::get('/home', 'HomeController@index');

// Route::group ?? esim. auth (delete vain adminille)
Route::get('/comments/{id}', 'CommentsController@index');
Route::delete('/comments/{id}', 'CommentsController@delete');
Route::post('/tasklists/{id}/comments', 'CommentsController@save');

