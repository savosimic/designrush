<?php

use App\Http\Controllers\ServiceProviderController;
use App\Models\ServiceProvider;
use Illuminate\Support\Facades\Cache;
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


Route::get('/', function () {
    return redirect()->route('providers.index');
});

Route::get('/providers', [ServiceProviderController::class, 'index'])
    ->name('providers.index');

Route::get('/providers/{provider}', [ServiceProviderController::class, 'show'])
    ->name('providers.show');


