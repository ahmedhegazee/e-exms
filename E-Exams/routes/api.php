<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
    Route::get('/levels','API\LevelsController@getLevels');
    Route::get('email/verify/{id}', 'VerificationApiController@verify')->name('verificationapi.verify');
    Route::post('/password/create', 'PasswordResetController@create');
    Route::get('/password/find/{token}', 'PasswordResetController@find');
    Route::post('/password/reset', 'PasswordResetController@reset');
Route::get('email/resend', 'VerificationApiController@resend')->name('verificationapi.resend');
    Route::group(['middleware' => ['auth:api']], function(){
        Route::post('/user/update', [\App\Http\Controllers\API\UserController::class,'update']);

//    Route::post('details', 'API\UserController@details');
        Route::apiResources([
            '/level' => 'API\LevelsController',
            '/subject' => 'API\SubjectsController',
            '/subject/{subject}/chapter' => 'API\ChaptersController',
            '/subject/{subject}/chapter/{chapter}/question' => 'API\QuestionsController',
            '/dept' => 'API\DepartmentsController',
//            '/term'=>'API\StudyingTermController',
//            '/year'=>'API\StudyingYearController',
            '/professor'=>'API\ProfessorsController',
            '/subject/{subject}/exam'=>'API\ExamsController',
            '/subject/{subject}/training'=>'API\TrainingExamsController',
        ]);

        Route::post( '/training/{exam}/answers','API\TrainingExamsController@storeAnswers');

        Route::post('/level/{level}/dept', 'API\LevelsController@addDepartments');
        Route::get('/level/{level}/dept', 'API\LevelsController@getDepartments');
//        Route::post('/year/{year}/terms', 'API\StudyingYearController@addTerms');
//        Route::get('/year/{year}/terms', 'API\StudyingYearController@getTerms');
//        Route::patch('/year/{year}/term/{term}', 'API\StudyingYearController@updateTerm');
        Route::get('/subjects/professors','API\SubjectsController@getProfessorSubjects');
        Route::get('/subjects/students','API\SubjectsController@getStudentSubjects');
        Route::get('/subject/{subject}/wrong-answers','API\SubjectsController@getWrongAnswers');
    });
});
Route::fallback(function(){
    return response()->json(['message' => 'Not Found.'], 404);
})->name('api.fallback.404');
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
//Route::resource('/level','LevelsController')->middleware('api');
