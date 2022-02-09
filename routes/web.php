<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WeatherController::class, 'renderHomePage']);

Route::post('/weather', [WeatherController::class, 'getRequestList']);
Route::get('/weather', [WeatherController::class, 'getRequestList']);

Route::delete('/erase', [WeatherController::class, 'eraseWeather']);
Route::get('/weather/temperature', [WeatherController::class, 'getTemperature']);
Route::get('/weather/location', [WeatherController::class, 'getLocation']);

Route::post('/addRecord', [WeatherController::class, 'create']);
Route::post('/updateRecord', [WeatherController::class, 'updateWeather']);
