<?php

use App\Http\Controllers\Api\PropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/properties/{property:slug}', [PropertyController::class, 'show']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
