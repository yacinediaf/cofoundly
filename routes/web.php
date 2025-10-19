<?php

use App\Http\Controllers\CurrentStartupController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StartupBannerController;
use App\Http\Controllers\StartupController;
use App\Http\Controllers\StartupLogoController;
use App\Http\Controllers\StartupMemberController;
use App\Http\Controllers\StartupRequestController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserStartupController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [StartupController::class, 'index'])->name('startups.index');
//Startups
Route::get('/startups', [StartupController::class, 'index'])->name('startups.index');
Route::get('/startups/{startup}', [StartupController::class, 'show'])->name('startups.show');

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
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    //Switch Current Startup
    Route::put('/current-startup', [CurrentStartupController::class, 'update'])->name('current-startup.update');

    Route::get('/startups/create', [UserStartupController::class, 'create'])->name('user-startups.create');
    Route::post('/startups', [UserStartupController::class, 'store'])->name('user-startups.store');
    Route::get('user/startups/{startup}', [UserStartupController::class, 'show'])->name('user-startups.show');
    Route::put('user/startups/{startup}', [UserStartupController::class, 'update'])->name('user-startups.update');

    Route::delete('/startups/{startup}/logo', [StartupLogoController::class, 'destroy'])->name('current-startup-logo.destroy');
    Route::delete('/startups/{startup}/banner', [StartupBannerController::class, 'destroy'])->name('current-startup-banner.destroy');

    //Requests
    Route::get('/startups/{startup}/requests', [StartupRequestController::class, 'index'])->name('startup.requests.index');
    Route::post('/startups/{startup}/requests', [StartupRequestController::class, 'store'])->name('startup.requests');
    Route::delete('/startup-requests/{request:code}', [StartupRequestController::class, 'delete'])->name('startup.requests.delete');

    //Startup Members
    Route::post('/startups/{startup}/members', [StartupMemberController::class, 'store'])->name('startup.members.store');

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
    Route::put('comments/{comment}', [TaskCommentController::class, 'update'])->name('task.comment.update');
    Route::delete('comments/{comment}', [TaskCommentController::class, 'delete'])->name('task.comment.delete');
});
