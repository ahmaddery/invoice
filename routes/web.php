<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleControllerController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StoreController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/auth/google', [App\Http\Controllers\GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\GoogleController::class, 'handleGooglecallback'])->name('auth.google.callback');


route::get('admin/dashboard',[HomeController::class,'index'])->middleware(['auth','admin']);


Route::middleware('admin')->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::put('users/{id}/restore', [UserController::class, 'restore'])->name('admin.users.restore');
    Route::delete('admin/users/{id}/permanently-delete', 'App\Http\Controllers\Admin\UserController@destroyPermanent')
    ->name('admin.users.permanently-delete');
});


Route::middleware('admin')->name('admin.')->group(function () {
    Route::get('/stores', [StoreController::class, 'index'])->name('stores');
    Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');
    Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');
    Route::get('/stores/{id}/edit', [StoreController::class, 'edit'])->name('stores.edit');
    Route::put('/stores/{id}', [StoreController::class, 'update'])->name('stores.update');
    Route::get('/stores/{id}/soft-delete', [StoreController::class, 'softDelete'])->name('stores.soft-delete');
    Route::delete('/stores/{id}/delete', [StoreController::class, 'delete'])->name('stores.delete');
    Route::get('/stores/{id}/restore', [StoreController::class, 'restore'])->name('stores.restore');
});