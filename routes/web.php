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

Route::post('/weather', [WeatherController::class, 'getAllWeatherRecord']);
Route::get('/weather', [WeatherController::class, 'weather']);
Route::post('/customWeatherSearch', [WeatherController::class, 'getWeatherRequestList']);

Route::get('/erase', [WeatherController::class, 'eraseWeatherRecord']);
Route::get('/weather/temperature', [WeatherController::class, 'getWeatherByTemperature']);
Route::get('/weather/location', [WeatherController::class, 'getWeatherRequestList']); //will work as the basic one when parameters are given

Route::post('/addWeatherRecord', [WeatherController::class, 'addWeatherRecord']);
Route::post('/updateWeatherRecord', [WeatherController::class, 'updateWeatherRecord']);
