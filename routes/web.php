<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamMarkController;

Route::get('/', function () {
    return view('welcome');
});

Route::post(
    '/exam-marks/{exam}',
    [ExamMarkController::class, 'update']
)
    ->name('exam-marks.update');
