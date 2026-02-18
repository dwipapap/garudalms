<?php

use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Guest-only routes (auth not required)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('livewire.auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('livewire.auth.register');
    })->name('register');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', \App\Livewire\Dashboard::class)->name('dashboard');

    // Courses
    Route::get('/courses', \App\Livewire\Courses\Index::class)->name('courses.index');

    Route::get('/courses/{id}', function ($id) {
        return view('livewire.courses.show', ['id' => $id]);
    })->name('courses.show');

    // Create and edit courses (dosen only)
    Route::middleware('role:dosen')->group(function () {
        Route::get('/courses/create', \App\Livewire\Courses\Create::class)->name('courses.create');
        Route::get('/courses/{id}/edit', \App\Livewire\Courses\Edit::class)->name('courses.edit');
    });

    // Materials
    Route::get('/materials', \App\Livewire\Materials\Index::class)->name('materials.index');

    Route::middleware('role:dosen')->group(function () {
        Route::get('/materials/create', \App\Livewire\Materials\Create::class)->name('materials.create');
    });

    Route::get('/materials/{id}', function ($id) {
        return view('livewire.materials.show', ['id' => $id]);
    })->name('materials.show');

    Route::get('/materials/{id}/edit', function ($id) {
        return view('livewire.materials.edit', ['id' => $id]);
    })->name('materials.edit');

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
        Route::get('/reports', function () {
            return view('livewire.reports.index');
        })->name('reports.index');

        Route::get('/reports/courses', \App\Livewire\Reports\Courses::class)->name('reports.courses');

        Route::get('/reports/assignments', \App\Livewire\Reports\Assignments::class)->name('reports.assignments');

        Route::get('/reports/students/{id}', function ($id) {
            return view('livewire.reports.students', ['id' => $id]);
        })->name('reports.students');
    });
});
