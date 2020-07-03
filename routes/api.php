<?php

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

Route::post('/login', 'Auth\AuthController@login');

Route::middleware(['auth:sanctum'])->group(function () {
  Route::get('/users', 'UserController@index');
  
  Route::apiResource('boards', 'BoardController');
  Route::apiResource('tasks', 'TaskController');
  Route::apiResource('labels', 'LabelController');
  
  Route::post('/tasks/attach', 'TaskController@attachToBoard');
  
  Route::post('/label/attach', 'LabelController@attachToTask');
  
  Route::get('/tasks/label/{label_id}', 'TaskController@getByLabel');
  Route::get('/tasks/status/{status}', 'TaskController@getByStatus');
  
});
