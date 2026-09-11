<?php

use App\Http\Controllers\PosAppDownloadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Standalone POS Desktop & Offline App Downloads
Route::get('/downloads/pos-app/{platform}', [PosAppDownloadController::class, 'download'])
    ->name('pos.app.download');

// Executive Restaurant Reports Export & Print Routes
use App\Http\Controllers\RestaurantReportController;

Route::get('/admin/reports/export/{type}', [RestaurantReportController::class, 'exportCsv'])
    ->name('admin.reports.export.csv');

Route::get('/admin/reports/json/{type}', [RestaurantReportController::class, 'exportJson'])
    ->name('admin.reports.export.json');

Route::get('/admin/reports/print/{type}', [RestaurantReportController::class, 'printReport'])
    ->name('admin.reports.print');

