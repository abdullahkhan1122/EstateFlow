<?php

use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Buyer\DashboardController as BuyerDashboardController;
use App\Http\Controllers\Buyer\FavoriteController;
use App\Http\Controllers\Buyer\SavedSearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyInquiryController;
use App\Http\Controllers\Public\AgentProfileController;
use App\Http\Controllers\PublicPropertyController;
use App\Http\Controllers\ViewingRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicPropertyController::class, 'home'])->name('home');
Route::get('/properties', [PublicPropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{property:slug}', [PublicPropertyController::class, 'show'])->name('properties.show');
Route::get('/agents/{agent}', [AgentProfileController::class, 'show'])->name('agents.show');
Route::middleware('guest')->group(function () {
    Route::get('/account/register', [RegisteredUserController::class, 'create'])->name('buyer.register');
    Route::post('/account/register', [RegisteredUserController::class, 'store'])->name('buyer.register.store');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified', 'can:access-admin'])->name('dashboard');
Route::get('/buyer/dashboard', BuyerDashboardController::class)->middleware(['auth', 'verified', 'can:access-buyer'])->name('buyer.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified', 'can:access-buyer'])->group(function () {
    Route::post('/properties/{property:slug}/inquiries', [PropertyInquiryController::class, 'store'])->name('properties.inquiries.store');
    Route::post('/properties/{property:slug}/viewings', [ViewingRequestController::class, 'store'])->name('properties.viewings.store');
    Route::post('/properties/{property:slug}/favorite', [FavoriteController::class, 'toggle'])->name('properties.favorite.toggle');
    Route::post('/saved-searches', [SavedSearchController::class, 'store'])->name('saved-searches.store');
});

Route::middleware(['auth', 'verified', 'can:access-admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('leads', [LeadController::class, 'index'])->name('leads.index');
        Route::resource('properties', PropertyController::class)->except('show');
        Route::resource('agents', AgentController::class)->except('show')->parameters(['agents' => 'agent']);
    });

require __DIR__.'/auth.php';
