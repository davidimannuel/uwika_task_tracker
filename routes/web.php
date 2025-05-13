<?php

use Illuminate\Support\Facades\Route;

// Customize default redirect after login
Route::get('/home', function () {
    return redirect('/'); // e.g. /dashboard or /tasks
});

Route::get('/login', \App\Livewire\Login::class)->name('login')->middleware('guest');
Route::post('/logout', \App\Http\Controllers\LogoutController::class)->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/', \App\Livewire\Home::class)->name('home');
    Route::get('/workspaces', App\Livewire\Workspaces\Index::class)->name('workspaces.index');
    Route::get('/workspaces/{workspace}/tasks', App\Livewire\Tasks\Index::class)->name('workspaces.tasks.index');
    Route::get('/workspaces/{workspace}/tasks/board', App\Livewire\Tasks\Board::class)->name('workspaces.tasks.board');
    Route::get('/workspaces/{workspace}/members', App\Livewire\Workspaces\Members::class)->name('workspaces.members');
});
