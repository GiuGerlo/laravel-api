<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\studentController;
use App\Http\Controllers\Api\teacherController;

// STUDENTS
Route::get('/students', [studentController::class, 'index']);

Route::get('/students/{id}', [studentController::class, 'show']);

Route::post('/students', [studentController::class, 'store']);

Route::put('/students/{id}', [studentController::class, 'update']);

Route::patch('/students/{id}', [studentController::class, 'updatePartial']);

Route::delete('/students/{id}', [studentController::class, 'destroy']);

// TEACHERS
Route::get('/teachers', [teacherController::class, 'index']);

Route::get('/teachers/{id}', [teacherController::class, 'show']);

Route::post('/teachers', [teacherController::class, 'store']);

Route::put('/teachers/{id}', [teacherController::class, 'update']);

Route::patch('/teachers/{id}', [teacherController::class, 'updatePartial']);

Route::delete('/teachers/{id}', [teacherController::class, 'destroy']);