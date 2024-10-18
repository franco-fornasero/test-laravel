<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BreweryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//login
Route::post('/login', [AuthController::class, 'login']);
//logout
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->get('/breweries', [BreweryController::class, 'index']);
Route::middleware('auth:sanctum')->get('/breweries/filters', [BreweryController::class, 'getAllFilters']);
