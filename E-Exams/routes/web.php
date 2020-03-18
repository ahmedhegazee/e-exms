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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Auth::routes(['verify' => true]);

//Route::get('/home', 'HomeController@index')->name('home');
//
//Route::view('/control-panel/subjects', 'subjects');
////Route::resource('/subject','SubjectsController');
//Route::view('/control-panel/levels', 'levels');
////Route::resource('/level','LevelsController')->except(['edit','create','show']);
////Route::resource('/level/{level}/dept','DepartmentsController')->except(['edit','create','show']);
////no create or edit
//Route::apiResources([
//    '/level' => 'API\LevelsController',
//    '/subject' => 'API\SubjectsController',
//    '/subject/{subject}/chapter' => 'API\ChaptersController',
//    '/subject/{subject}/chapter/{chapter}/question' => 'API\QuestionsController',
//    '/dept' => 'API\DepartmentsController',
//]);
//Route::post('/level/{level}/dept', 'API\LevelsController@addDepartments');
