<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Get all the polls
Route::get('polls', 'PollsController@index');
// Get a single poll
Route::get('polls/{id}', 'PollsController@show');
// Adding a poll
Route::post('polls', 'PollsController@store');
// Editing a poll
Route::put('polls/{poll}', 'PollsController@update');
// Deleting a poll
Route::delete('polls/{poll}', 'PollsController@destroy');
// Get all the errors
Route::any('errors', 'PollsController@errors');
// Route::any('errors/{errorId}', 'PollsController@errors')->name('errors'); // Test out custom errors (Redirect to a custom error handling method)

// Create all the API related endpoints for questions
Route::apiResource('questions', 'QuestionsController');
// This route will retrieve all the questions for a given poll
Route::get('polls/{poll}/questions', 'PollsController@questions');
// This route allows us to download a file
Route::get('files/get', 'FilesController@show');
// This route allows us to upload a file
Route::post('files/create', 'FilesController@create');
