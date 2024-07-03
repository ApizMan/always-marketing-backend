<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RespondentController;
use App\Http\Controllers\SurveyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')
    ->as('auth.')
    ->group(function () {
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('register', [AuthController::class, 'register'])->name('register');
        Route::post('login_with_token', [AuthController::class, 'loginWithToken'])
            ->middleware('auth:sanctum')
            ->name('login_with_token');
        Route::get('logout', [AuthController::class, 'logout'])
            ->middleware('auth:sanctum')
            ->name('logout');
    });


Route::middleware('auth:sanctum')->group(
    function () {
        Route::prefix('survey')
            ->as('survey.')
            ->group(function () {
                Route::get('list', [SurveyController::class, 'index'])
                    ->name('list');
                Route::post('create', [SurveyController::class, 'store'])
                    ->name('create');
                Route::put('update/{id}', [SurveyController::class, 'edit'])
                    ->name('edit');
                Route::delete('delete/{id}', [SurveyController::class, 'destroy'])
                    ->name('destroy');

                Route::prefix('{id}/question')
                    ->as('question.')
                    ->group(function () {
                        Route::get('list', [QuestionController::class, 'index'])
                            ->name('list');
                        Route::post('create', [QuestionController::class, 'store'])
                            ->name('create');
                        Route::put('update/{q_id}', [QuestionController::class, 'edit'])
                            ->name('edit');
                        Route::delete('delete/{q_id}', [QuestionController::class, 'destroy'])
                            ->name('destroy');

                        Route::prefix('respondent')
                            ->as('respondent.')
                            ->group(function () {
                                Route::get('list', [RespondentController::class, 'index'])
                                    ->name('list');
                                Route::post('create', [RespondentController::class, 'store'])
                                    ->name('create');
                                Route::put('update/{id}', [RespondentController::class, 'edit'])
                                    ->name('edit');
                                Route::delete('delete/{id}', [RespondentController::class, 'destroy'])
                                    ->name('destroy');

                                Route::prefix('{q_id}/answer')
                                    ->as('answer.')
                                    ->group(function () {
                                        Route::get('list', [AnswerController::class, 'index'])
                                            ->name('list');
                                        Route::post('create/{r_id}', [AnswerController::class, 'store'])
                                            ->name('create');
                                    });
                            });
                    });
            });
    }
);

Route::prefix('survey')
    ->as('survey.')
    ->group(function () {
        Route::get('list-guest', [SurveyController::class, 'index'])
            ->name('list-guest');

        Route::prefix('{id}/question')
            ->as('question.')
            ->group(function () {
                Route::get('list', [QuestionController::class, 'index'])
                    ->name('list');
                Route::post('create', [QuestionController::class, 'store'])
                    ->name('create');
                Route::put('update/{q_id}', [QuestionController::class, 'edit'])
                    ->name('edit');
                Route::delete('delete/{q_id}', [QuestionController::class, 'destroy'])
                    ->name('destroy');

                Route::prefix('respondent')
                    ->as('respondent.')
                    ->group(function () {
                        Route::get('list', [RespondentController::class, 'index'])
                            ->name('list');
                        Route::post('create', [RespondentController::class, 'store'])
                            ->name('create');
                        Route::put('update/{id}', [RespondentController::class, 'edit'])
                            ->name('edit');
                        Route::delete('delete/{id}', [RespondentController::class, 'destroy'])
                            ->name('destroy');

                        Route::prefix('{q_id}/answer')
                            ->as('answer.')
                            ->group(function () {
                                Route::get('list', [AnswerController::class, 'index'])
                                    ->name('list');
                                Route::post('create/{r_id}', [AnswerController::class, 'store'])
                                    ->name('create');
                            });
                    });
            });
    });
