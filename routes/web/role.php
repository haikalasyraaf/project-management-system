<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'roles'], function() {
    Route::get('', [RoleController::class, 'index'])->name('role.index');
    Route::post('{roles}/edit', [RoleController::class, 'update'])->name('role.update'); 
});