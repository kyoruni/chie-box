<?php

use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::apiResource('questions', QuestionController::class);
