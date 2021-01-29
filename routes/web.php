<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssignmentStateController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\HomeController;
use App\Models\Assignment;
use App\Models\AssignmentState;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('/assignment')->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/{id}', [AssignmentController::class, 'show'])->name('assignment');
    Route::post('/{id}/status/{state}', [AssignmentStateController::class, 'store'])->name('assignmentState.store');
    Route::get('/{assignment}/edit', [AssignmentController::class, 'edit'])->middleware(['admin'])->name('assignment.edit');
    Route::put('/{assignment}', [AssignmentController::class, 'update'])->middleware(['admin'])->name('assignment.update');
});

Route::prefix('/dashboard')->middleware(['auth:sanctum', 'verified', 'admin'])->group(function () {
    Route::get('/', [Dashboard::class, 'index'])->name('dashboard');
    Route::get('/create-assignment', [AssignmentController::class, 'create'])->name('assignment.create');
    Route::post('/store-assignment', [AssignmentController::class, 'store'])->name("assignment.store");
    Route::post('admin/user/{id}', [Dashboard::class, 'rights'])->name("admin.rights");
});
