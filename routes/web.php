<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DataTablesController;

Route::get('ajax-datatable-crud', [DataTablesController::class, 'index']);
Route::get('/exportpdf', [DataTablesController::class, 'exportpdf']);

Route::post('add-update-book', [DataTablesController::class, 'store']);
Route::post('edit-book', [DataTablesController::class, 'edit']);
Route::post('delete-book', [DataTablesController::class, 'destroy']);
Route::resource('export', 'ExportController'); 

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
