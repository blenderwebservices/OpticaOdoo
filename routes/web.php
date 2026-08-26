<?php

use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StoreController::class, 'index'])->name('store.index');
Route::get('/producto/{slug}', [StoreController::class, 'show'])->name('store.show');
Route::post('/citas/agendar', [StoreController::class, 'bookAppointment'])->name('store.book_appointment');
Route::post('/checkout', [StoreController::class, 'checkout'])->name('store.checkout');
