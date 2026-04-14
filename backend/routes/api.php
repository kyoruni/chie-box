<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::apiResource('questions', QuestionController::class);

Route::post('questions/{question}/answers', [AnswerController::class, 'store']);
Route::put('answers/{answer}', [AnswerController::class, 'update']);
Route::delete('answers/{answer}', [AnswerController::class, 'destroy']);
