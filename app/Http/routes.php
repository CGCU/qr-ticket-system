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
  return 'QR Ticket Manager v2.0';
});

// Events routes
Route::get('/events', 'EventController@getAll');
Route::post('/events', 'EventController@create');
Route::get('/events/{id}', 'EventController@read');
Route::patch('/events/{id}', 'EventController@update');
Route::delete('/events/{id}', 'EventController@delete');

// Tickets routes
Route::get('/events/{eventId}/tickets', 'TicketController@getAll');
Route::post('/events/{eventId}/tickets', 'TicketController@create');
Route::post('/events/{eventId}/tickets/import', 'TicketController@import');
Route::post('/events/{eventId}/tickets/email', 'TicketController@sendEmails');
Route::delete('/events/{eventId}/tickets/{id}', 'TicketController@delete');

// Union product routes
Route::get('/events/{eventId}/union-products', 'UnionProductController@getAll');
Route::post('/events/{eventId}/union-products', 'UnionProductController@create');
Route::delete('/events/{eventId}/union-products/{id}', 'UnionProductController@delete');
