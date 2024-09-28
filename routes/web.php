<?php

use Illuminate\Support\Facades\App;

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\ComplaintsController;
use App\Http\Controllers\InstructionsController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

App::setLocale('ru');

Route::get('/', [InstructionsController::class, 'list'])->name('main');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/register', [LoginController::class, 'register'])->name('register');

Route::post('/login', [LoginController::class, 'authentication'])->name('authentication');
Route::post('/register', [LoginController::class, 'registerCreate'])->name('registerCreate');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/instruction-form', [InstructionsController::class, 'form'])->name('instruction-form');
Route::get('/instruction-view', [InstructionsController::class, 'view'])->name('instruction-view');

Route::post('/instruction/create', [InstructionsController::class, 'create'])->name('instruction-create');
Route::post('/instruction/delete', [InstructionsController::class, 'delete'])->name('instruction-delete');
Route::post('/instruction/accept', [InstructionsController::class, 'accept'])->name('instruction-accept');

Route::get('/admin-panel/instructions', [AdminPanelController::class, 'instructions'])->name('admin-instructions');
Route::get('/admin-panel/users', [AdminPanelController::class, 'users'])->name('admin-users');
Route::get('/admin-panel/complaints', [AdminPanelController::class, 'complaints'])->name('admin-complaints');

Route::get('/user/create', [LoginController::class, 'create'])->name('user-create');
Route::post('/user/delete', [LoginController::class, 'delete'])->name('user-delete');
Route::post('/user/block', [LoginController::class, 'block'])->name('user-block');

Route::post('/complaint/create', [ComplaintsController::class, 'create'])->name('complaint-create');
Route::post('/complaint/delete', [ComplaintsController::class, 'delete'])->name('complaint-delete');