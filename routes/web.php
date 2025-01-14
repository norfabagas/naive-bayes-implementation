<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/student', 'StudentController@index')->name('student.index');
    Route::post('/student', 'StudentController@submitExcel')->name('student.submitExcel');
    Route::get('/student/test/single', 'StudentController@test')->name('student.test');
    Route::get('/student/test/excel', 'StudentController@testExcel')->name('student.test.excel');
    Route::get('/student/statistic', 'StudentController@statistic')->name('student.statistic');
});