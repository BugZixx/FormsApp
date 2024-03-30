<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Forms routes

    Route::get('/forms', [FormController::class, 'index'])->name('forms');
    Route::get('/forms/{form}', [FormController::class, 'show'])->name('answeringform');

    // Answers routes

    Route::get('/answers', [AnswerController::class, 'index'])->name('answers.index');
    Route::post('/answers/{answer}', [AnswerController::class, 'store'])->name('answers.store');
    Route::get('/answers/{answer}', [AnswerController::class, 'show'])->name('answers.show');

    // Profile routes

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
