<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

Route::get('/email/verify', function () {
    return Inertia::render('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    //Projects
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
    Route::get('/projects/@{project:project_code}', [ProjectController::class, 'show'])->name('projects.show');

    //Tasks
    Route::get('projects/@{project:project_code}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::get('projects/@{project:project_code}/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::post('projects/@{project:project_code}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('projects/@{project:project_code}/tasks/{task}', [TaskController::class, 'replace'])->name('tasks.replace');
    Route::patch('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('projects/@{project:project_code}/tasks/{task}', [TaskController::class, 'delete'])->name('tasks.delete');
    //Tags
    Route::post('projects/@{project:project_code}/tags', [TagController::class, 'store'])->name('tags.store');
    //Comments
    Route::post('/task/{task}/comments', [TaskCommentController::class, 'store'])->name('task.comment.store');
});
