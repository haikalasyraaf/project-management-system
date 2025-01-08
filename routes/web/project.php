<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'projects'], function() {
    Route::get('', [ProjectController::class, 'index'])->name('project.index');

    Route::group(['prefix' => 'create'], function() {
        Route::get('', [ProjectController::class, 'create'])->name('project.create');
        Route::post('', [ProjectController::class, 'store'])->name('project.store');
    });

    Route::group(['prefix' => '{project}'], function() {
        Route::get('destroy', [ProjectController::class, 'destroy'])->name('project.destroy');

        Route::group(['prefix' => 'edit'], function() {
            Route::get('', [ProjectController::class, 'edit'])->name('project.edit');
            Route::post('', [ProjectController::class, 'update'])->name('project.update'); 
        });
    });
});