<?php

use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProjectController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/teams', [TeamController::class, 'index'])->name('teams');
    Route::post('/teams/{team}', [TeamController::class, 'edit'])->name('team.edit');
    Route::put('/teams/{team}', [TeamController::class, 'update'])->name('team.update');
    Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('team.delete');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
});


