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

Route::prefix('manager')->namespace('Manager')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::middleware(['isadmin'])->group(function () {
            Route::get('/rooms', 'RoomsController@index');
            Route::get('/rooms/create', 'RoomsController@create');
            Route::post('/rooms', 'RoomsController@store');
            Route::delete('/rooms/{room}', 'RoomsController@destroy');

            Route::get('/users', 'UsersController@index');
            Route::get('/users/create', 'UsersController@create');
            Route::get('/users/{user}/edit', 'UsersController@edit');
            Route::post('/users', 'UsersController@store');
            Route::patch('/users/{user}', 'UsersController@update');
            Route::delete('/users/{user}', 'UsersController@destroy');
        });

        Route::get('/events', 'RoomEventsController@index');
        Route::get('/events/create', 'RoomEventsController@create');
        Route::get('/events/{event}/edit', 'RoomEventsController@edit');
        Route::post('/events', 'RoomEventsController@store');
        Route::patch('/events/{event}', 'RoomEventsController@update');
        Route::delete('/events/{event}', 'RoomEventsController@destroy');
    });
});


Route::get('/', 'RoomsController@index');
Route::get('/rooms/{room}/{lesson?}', 'RoomsController@show');
Route::get('/rozvrh/{room}', 'TimeScheduleController@show');
Route::get('/home', 'RoomsController@index')->name('home');

Route::get('/manager', function () {
    return redirect('/manager/rooms');
});

Auth::routes([ 'register' => false ]);



