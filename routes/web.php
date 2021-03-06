<?php

use App\Http\Controllers\LogController;
use App\Http\Controllers\ProcesoController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
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
    return redirect('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/teams', [TeamController::class, 'index'])->name('teams');
    Route::post('/teams/{team}', [TeamController::class, 'edit'])->name('team.edit');
    Route::put('/teams/{team}', [TeamController::class, 'update'])->name('team.update');
    Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('team.delete');

    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('project.detail');

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('task.detail');

    Route::get('/processes', [ProcesoController::class, 'index'])->name('processes');

    Route::get('/logs', LogController::class)->name('logs');
});


