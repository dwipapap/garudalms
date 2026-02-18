<?php

use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Guest-only routes (auth not required)
Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');

    Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', function () {
        Illuminate\Support\Facades\Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    })->name('logout');

    // Dashboard
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

    // Courses
    Route::get('/courses', \App\Livewire\Courses\Index::class)->name('courses.index');

    Route::get('/courses/{id}', \App\Livewire\Courses\Show::class)->name('courses.show');

    // Create and edit courses (dosen only)
    Route::middleware('role:dosen')->group(function () {
        Route::get('/courses/create', \App\Livewire\Courses\Create::class)->name('courses.create');
        Route::get('/courses/{id}/edit', \App\Livewire\Courses\Edit::class)->name('courses.edit');
    });

    // Materials
    Route::get('/materials', \App\Livewire\Materials\Index::class)->name('materials.index');

    Route::middleware('role:dosen')->group(function () {
        Route::get('/materials/create', \App\Livewire\Materials\Create::class)->name('materials.create');
        Route::get('/materials/{id}/edit', \App\Livewire\Materials\Edit::class)->name('materials.edit');
    });

    Route::get('/materials/{id}', \App\Livewire\Materials\Show::class)->name('materials.show');

    // Assignments
    Route::get('/assignments', \App\Livewire\Assignments\Index::class)->name('assignments.index');

    Route::middleware('role:dosen')->group(function () {
        Route::get('/assignments/create', \App\Livewire\Assignments\Create::class)->name('assignments.create');
    });

    Route::get('/assignments/{id}', \App\Livewire\Assignments\Show::class)->name('assignments.show');

    // Discussions
    Route::get('/discussions', \App\Livewire\Discussions\Index::class)->name('discussions.index');
    Route::get('/discussions/{id}', \App\Livewire\Discussions\Show::class)->name('discussions.show');

    // Reports (dosen only)
    Route::middleware('role:dosen')->group(function () {
        Route::get('/reports', \App\Livewire\Reports\Index::class)->name('reports.index');

        Route::get('/reports/courses', \App\Livewire\Reports\Courses::class)->name('reports.courses');

        Route::get('/reports/assignments', \App\Livewire\Reports\Assignments::class)->name('reports.assignments');

        Route::get('/reports/students/{id}', \App\Livewire\Reports\Students::class)->name('reports.students');
    });
});
