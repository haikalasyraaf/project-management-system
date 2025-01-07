<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users'], function() {
    Route::get('', [UserController::class, 'index'])->name('user.index');

    Route::group(['prefix' => 'create'], function() {
        Route::get('', [UserController::class, 'create'])->name('user.create');
        Route::post('', [UserController::class, 'store'])->name('user.store');
    });

    Route::group(['prefix' => '{user}'], function() {
        Route::get('destroy', [UserController::class, 'destroy'])->name('user.destroy');

        Route::group(['prefix' => 'edit'], function() {
            Route::get('', [UserController::class, 'edit'])->name('user.edit');
            Route::post('', [UserController::class, 'update'])->name('user.update'); 
        });
    });
});