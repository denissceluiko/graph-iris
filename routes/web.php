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

Route::get('/', 'ProgramController@index');
Route::resource('import', 'ImportController');

Route::get('program', 'ProgramController@index')->name('program.index');
Route::group(['prefix' => 'program/{program}/{semester?}'], function() {
    Route::get('/', 'ProgramController@show')->name('program.show');
    Route::get('{course}', 'CourseController@show')->name('course.show');
});

Auth::routes();

Route::get('/home', 'ProgramController@index')->name('home');
