<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ImportController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::post('facebook', [FacebookController::class, 'postToFacebook']);


Route::post('/generate-pdf', [PDFController::class, 'generateHtmlToPDF']);


Route::post('/upload/image', [ImageController::class, 'upload'])->name('upload.image');

// import csv
Route::get('/import', function () {
    return view('import');
})->name('import');

Route::post('/import', [ImportController::class, 'import']);

// template read imports
Route::get('/importtemplate', function () {
    return view('importtemplate');
})->name('importtemplate');

Route::post('/importtemplate', [ImportController::class, 'importtemplate']);


require __DIR__.'/auth.php';
