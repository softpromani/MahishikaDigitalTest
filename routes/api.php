<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes for Mahishika Digital
|--------------------------------------------------------------------------
| RESTful endpoints powering the mega menu, search, services, portfolio,
| and consultation leads.
*/

Route::get('/menu', [ApiController::class, 'menu'])->name('api.menu');
Route::get('/search', [ApiController::class, 'search'])->name('api.search');
Route::get('/services', [ApiController::class, 'services'])->name('api.services');
Route::get('/portfolio', [ApiController::class, 'portfolio'])->name('api.portfolio');
Route::post('/consultations', [ApiController::class, 'storeConsultation'])->name('api.consultations.store');

