<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;

Route::apiResource('faculties', FacultyController::class);
Route::post('faculties/{id}/restore', [FacultyController::class, 'restore']);
Route::delete('faculties/{id}/force-delete', [FacultyController::class, 'forceDelete']);

Route::apiResource('campuses', CampusController::class);
Route::post('campuses/{id}/restore', [CampusController::class, 'restore']);
Route::delete('campuses/{id}/force-delete', [CampusController::class, 'forceDelete']);

Route::apiResource('departments', DepartmentController::class);
Route::post('departments/{id}/restore', [DepartmentController::class, 'restore']);
Route::delete('departments/{id}/force-delete', [DepartmentController::class, 'forceDelete']);

Route::apiResource('centers', CenterController::class);
Route::post('centers/{id}/restore', [CenterController::class, 'restore']);
Route::delete('centers/{id}/force-delete', [CenterController::class, 'forceDelete']);

Route::apiResource('majors', MajorController::class);
Route::post('majors/{id}/restore', [MajorController::class, 'restore']);
Route::delete('majors/{id}/force-delete', [MajorController::class, 'forceDelete']);

Route::apiResource('blocks', BlockController::class);
Route::post('blocks/{id}/restore', [BlockController::class, 'restore']);
Route::delete('blocks/{id}/force-delete', [BlockController::class, 'forceDelete']);

Route::apiResource('rooms', RoomController::class);
Route::post('rooms/{id}/restore', [RoomController::class, 'restore']);
Route::delete('rooms/{id}/force-delete', [RoomController::class, 'forceDelete']);

Route::apiResource('courses', CourseController::class);
Route::post('courses/{id}/restore', [CourseController::class, 'restore']);
Route::delete('courses/{id}/force-delete', [CourseController::class, 'forceDelete']);

Route::apiResource('semesters', SemesterController::class);
Route::post('semesters/{id}/restore', [SemesterController::class, 'restore']);
Route::delete('semesters/{id}/force-delete', [SemesterController::class, 'forceDelete']);

Route::apiResource('users', UserController::class);
Route::post('users/{id}/restore', [UserController::class, 'restore']);
Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete']);

Route::apiResource('students', StudentController::class)->except(['create', 'edit']);
Route::post('students/{id}/restore', [StudentController::class, 'restore']);
Route::delete('students/{id}/force-delete', [StudentController::class, 'forceDelete']);
