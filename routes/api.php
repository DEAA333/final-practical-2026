<?php
use App\Http\Controllers\Api\MaintenanceRequestApiController;
use Illuminate\Support\Facades\Route;

Route::get('/requests', [MaintenanceRequestApiController::class, 'index']);
Route::get('/requests/{maintenanceRequest}', [MaintenanceRequestApiController::class, 'show']);
