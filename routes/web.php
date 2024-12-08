<?php

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
    return redirect()->route('login');
    // return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/products/preview', [App\Http\Controllers\ProductController::class, 'preview'])->name('products.preview');
Route::resource('products',App\Http\Controllers\ProductController::class);
Route::resource('categories',App\Http\Controllers\CategoryController::class);
Route::get('/produits/catalog', [App\Http\Controllers\ProductController::class, 'printCatalog'])->name('products.catalog');
