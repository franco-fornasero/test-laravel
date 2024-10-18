<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('app');
// });

    

// Ruta de respaldo para manejar todas las demás rutas
Route::get('/{any}', function () {
    return view('app'); // Ajusta 'app' al nombre de tu vista principal
})->where('any', '.*');
