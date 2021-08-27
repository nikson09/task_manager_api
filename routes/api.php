<?php

use Illuminate\Http\Request;
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

Route::middleware(['auth:api'])->group(function () {
    Route::post('login', 'AuthController@login')->name('login')->withoutMiddleware('auth:api');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('registration', 'AuthController@registration')->withoutMiddleware('auth:api');

    Route::get('users', 'UserController@getUsers');

    Route::get('getTasks', 'TaskController@getTasks');
    Route::get('getTasksByUserId/{user_id}', 'TaskController@getTasksByUserId');
    Route::post('createTask', 'TaskController@createTask');
    Route::post('updateTask/{id}', 'TaskController@updateTask');
    Route::post('deleteTask/{id}', 'TaskController@deleteTask');

    Route::get('getStatuses', 'StatusController@getStatuses');
    Route::post('createStatus', 'StatusController@createStatus');
    Route::post('updateStatus/{id}', 'StatusController@updateStatus');
    Route::post('deleteStatus/{id}', 'StatusController@deleteStatus');
});
