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
Route::post('import/program', 'Import\ProgramController@import');

Route::resource('program', 'ProgramController');
Route::group(['prefix' => 'program/{program}/{semester?}'], function() {
    Route::get('/', 'ProgramController@show')->name('program.show');
    Route::get('{course}', 'CourseController@show')->name('course.show');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'ProgramController@index')->name('home');
