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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');

Route::group(['middleware'=>'auth'],function(){

// User Route URL
    require __DIR__.'/user.php';
    
});
Route::name('admin.')->prefix('admin')->middleware(['admincheck'])->group(function () {
    
    // Admin Route URL
    require __DIR__.'/admin.php';
    
});