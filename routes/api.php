<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\DepartmentController;


Route::apiResource('faculties', FacultyController::class);
Route::post('faculties/{id}/restore', [FacultyController::class, 'restore']);
Route::delete('faculties/{id}/force-delete', [FacultyController::class, 'forceDelete']);

Route::apiResource('campuses', CampusController::class);
Route::post('campuses/{id}/restore', [CampusController::class, 'restore']);
Route::delete('campuses/{id}/force-delete', [CampusController::class, 'forceDelete']);

Route::apiResource('departments', DepartmentController::class);
Route::post('departments/{id}/restore', [DepartmentController::class, 'restore']);
Route::delete('departments/{id}/force-delete', [DepartmentController::class, 'forceDelete']);
