<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'invoices'], function() {
    Route::get('', [InvoiceController::class, 'index'])->name('invoice.index');

    Route::group(['prefix' => 'create'], function() {
        Route::get('', [InvoiceController::class, 'create'])->name('invoice.create');
        Route::post('', [InvoiceController::class, 'store'])->name('invoice.store');
    });

    Route::group(['prefix' => '{invoice}'], function() {
        Route::get('show', [InvoiceController::class, 'show'])->name('invoice.show');
        Route::get('mark-as-paid', [InvoiceController::class, 'markAsPaid'])->name('invoice.mark-as-paid');
        Route::post('destroy', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
    });
});