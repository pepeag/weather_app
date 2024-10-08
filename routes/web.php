<?php

use App\Http\Controllers\WeatherApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WeatherApiController::class, 'index'])->name('home');
Route::get('/weather', [WeatherApiController::class, 'getWeather'])->name('weather');
