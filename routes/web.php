<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\CompetitionController;

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

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:admin')->group(function () {
        Route::post('/change-step', [DashboardController::class, 'changeStep'])->name('dashboard.change_step');

        Route::get('/team', [TeamController::class, 'index'])->name('team.index');
        Route::post('/team/{profile}/verification/general', [TeamController::class, 'verifGeneral'])->name('team.verif.general');
        Route::post('/team/{profile}/verification/college', [TeamController::class, 'verifCollege'])->name('team.verif.college');
    });

    Route::middleware('role:participant')->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');
    
        Route::get('/competition', [CompetitionController::class, 'index'])->name('competition.index');
        Route::post('/competition/{profile}/add', [CompetitionController::class, 'addCompetition'])->name('competition.add');
    });
});
