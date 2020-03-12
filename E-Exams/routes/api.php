<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
Route::group(['middleware'=>'localization'],function (){
    Route::post('login', 'API\UserController@login');
    Route::post('register', 'API\UserController@register');
    Route::group(['middleware' => ['auth:api']], function(){
//    Route::post('details', 'API\UserController@details');
        Route::apiResources([
            '/level' => 'API\LevelsController',
            '/subject' => 'API\SubjectsController',
            '/subject/{subject}/chapter' => 'API\ChaptersController',
            '/subject/{subject}/chapter/{chapter}/question' => 'API\QuestionsController',
            '/dept' => 'API\DepartmentsController',
            '/term'=>'API\StudyingTermController',
            '/year'=>'API\StudyingYearController',
            '/professor'=>'API\ProfessorsController',
        ]);
        Route::post('/level/{level}/dept', 'API\LevelsController@addDepartments');
        Route::get('/level/{level}/dept', 'API\LevelsController@getDepartments');
        Route::post('/year/{year}/terms', 'API\StudyingYearController@addTerms');
        Route::get('/year/{year}/terms', 'API\StudyingYearController@getTerms');
        Route::patch('/year/{year}/term/{term}', 'API\StudyingYearController@updateTerm');

    });
});

Route::fallback(function(){
    return response()->json(['message' => 'Not Found.'], 404);
})->name('api.fallback.404');
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::resource('/level','LevelsController')->middleware('api');
