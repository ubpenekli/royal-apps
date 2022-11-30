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

    Route::name('authors.')->prefix('/authors')->group(
        function () {
            Route::get('/', 'App\\Http\\Controllers\\AuthorController@list')->name('list');
            Route::get('/{author_id}', 'App\\Http\\Controllers\\AuthorController@single')->name('single');
            Route::delete('/{author_id}', 'App\\Http\\Controllers\\AuthorController@delete')->name('delete');
        }
    );
    Route::name('books.')->prefix('books')->group(
        function () {
            Route::get('/create', 'App\\Http\\Controllers\\BookController@create')->name('create');
            Route::post('/', 'App\\Http\\Controllers\\BookController@store')->name('store');
            Route::delete('/{author_id}', 'App\\Http\\Controllers\\BookController@delete')->name('delete');
        }
    );
});
