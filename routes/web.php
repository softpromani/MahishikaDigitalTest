<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Mahishika Digital
|--------------------------------------------------------------------------
*/

// Public Services Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/storybook/frame', [HomeController::class, 'storybookFrame'])->name('storybook.frame');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Admin CMS Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Categories Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('categories.delete');

    // Subcategories Management
    Route::get('/subcategories', [AdminController::class, 'subcategories'])->name('subcategories');
    Route::post('/subcategories', [AdminController::class, 'storeSubCategory'])->name('subcategories.store');
    Route::put('/subcategories/{subCategory}', [AdminController::class, 'updateSubCategory'])->name('subcategories.update');
    Route::delete('/subcategories/{subCategory}', [AdminController::class, 'deleteSubCategory'])->name('subcategories.delete');

    // Portfolio / Articles Management
    Route::get('/portfolio', [AdminController::class, 'portfolio'])->name('portfolio');
    Route::post('/portfolio', [AdminController::class, 'storePortfolio'])->name('portfolio.store');
    Route::put('/portfolio/{portfolioArticle}', [AdminController::class, 'updatePortfolio'])->name('portfolio.update');
    Route::delete('/portfolio/{portfolioArticle}', [AdminController::class, 'deletePortfolio'])->name('portfolio.delete');

    // Consultations Leads
    Route::get('/consultations', [AdminController::class, 'consultations'])->name('consultations');
    Route::put('/consultations/{consultation}/status', [AdminController::class, 'updateConsultationStatus'])->name('consultations.status');
    Route::delete('/consultations/{consultation}', [AdminController::class, 'deleteConsultation'])->name('consultations.delete');
});
