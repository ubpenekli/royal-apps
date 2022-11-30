<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\\Http\\Controllers\\QtestsController@login_view')->name('login_view');
Route::post('/', 'App\\Http\\Controllers\\QtestsController@login')->name('login');

Route::name('dashboard.')->prefix('dashboard')->middleware('qtests')->group(function () {
    Route::get('/', 'App\\Http\\Controllers\\QtestsController@dashboard')->name('main');
    Route::get('/logout', 'App\\Http\\Controllers\\QtestsController@logout')->name('logout');
});
