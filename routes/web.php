<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('survey');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('beheer', function () {
        return view('beheer');

    });

    Route::middleware(['can:administrate'])->group(function () {
        Route::get('/roletable', function () {
            return view('livewire.role.index');
        });
        Route::get('/roledetails/{role}', function (App\Models\Role $role) {
            return view('livewire.role.details', compact('role'));
        })->name('roledetails');

        Route::get('/surveyanswerstable', function () {
            return view('livewire.surveyanswers.index');
        });
        Route::get('/surveyanswersdetails/{surveyanswers}', function (App\Models\SurveyAnswers $surveyanswers) {
            return view('livewire.surveyanswers.details', compact('surveyanswers'));
        })->name('surveyanswersdetails');


        Route::get('/usertable', function () {
            return view('livewire.user.index');
        });
        Route::get('/userdetails/{user}', function (App\Models\User $user) {
            return view('livewire.user.details', compact('user'));
        })->name('userdetails');
    });
    Route::get('/surveytable', function () {
        return view('livewire.survey.index');
    });
    Route::get('/surveydetails/{survey}', function (App\Models\Survey $survey) {
        return view('livewire.survey.details', compact('survey'));
    })->name('surveydetails');

    Route::get('/surveystudenttable', function () {
        return view('livewire.surveystudent.index');
    });
    Route::get('/surveystudentdetails/{surveystudent}', function (App\Models\SurveyStudent $surveystudent) {
        return view('livewire.surveystudent.details', compact('surveystudent'));
    })->name('surveystudentdetails');
    Route::get('/csv-export', [App\Http\Controllers\SurveyController::class, 'checkSurvey'])->name('survey-check');
    Route::get('/csv-export-list', [App\Http\Controllers\SurveyController::class, 'index'])->name('index');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
