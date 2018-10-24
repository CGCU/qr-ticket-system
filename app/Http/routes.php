<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::get('/', function () {
  return response()->json(['app' => 'CGCU Ticket Manager', 'version' => '2.0.0']);
});

Route::post('/migrations', ['middleware' => 'auth', function () {
  $exitCode = Artisan::call('migrate');
  return $exitCode;
}]);

// Events routes
Route::get('/events', ['uses' => 'EventController@getAll', 'middleware' => 'auth']);
Route::post('/events', ['uses' => 'EventController@create', 'middleware' => 'auth']);
Route::get('/events/{id}', ['uses' => 'EventController@read', 'middleware' => 'auth']);
Route::patch('/events/{id}', ['uses' => 'EventController@update', 'middleware' => 'auth']);
Route::delete('/events/{id}', ['uses' => 'EventController@delete', 'middleware' => 'auth']);

// Tickets routes
Route::get('/events/{eventId}/tickets', ['uses' => 'TicketController@getAll', 'middleware' => 'auth']);
Route::post('/events/{eventId}/tickets', ['uses' => 'TicketController@create', 'middleware' => 'auth']);
Route::post('/events/{eventId}/tickets/import', ['uses' => 'TicketController@import', 'middleware' => 'auth']);
Route::post('/events/{eventId}/tickets/email', ['uses' => 'TicketController@sendEmails', 'middleware' => 'auth']);
Route::delete('/events/{eventId}/tickets/{id}', ['uses' => 'TicketController@delete', 'middleware' => 'auth']);

// Union product routes
Route::get('/events/{eventId}/union-products', ['uses' => 'UnionProductController@getAll', 'middleware' => 'auth']);
Route::post('/events/{eventId}/union-products', ['uses' => 'UnionProductController@create', 'middleware' => 'auth']);
Route::delete('/events/{eventId}/union-products/{id}', ['uses' => 'UnionProductController@delete', 'middleware' => 'auth']);
