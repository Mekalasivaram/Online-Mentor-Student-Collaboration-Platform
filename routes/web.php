<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/setup-db', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh');
    return 'Database has been successfully refreshed! You can now go back and register.';
});

Route::get('/migrate', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate');
    return 'Database has been successfully migrated! New tables/columns added.';
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Student Routes
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/mentors', [StudentController::class, 'searchMentors'])->name('mentors');
        Route::get('/book/{mentor}', [BookingController::class, 'create'])->name('book.create');
        Route::post('/book', [BookingController::class, 'store'])->name('book.store');
        Route::post('/booking/{booking}/feedback', [BookingController::class, 'submitFeedback'])->name('booking.feedback');
    });

    // Mentor Routes
    Route::middleware('role:mentor')->prefix('mentor')->name('mentor.')->group(function () {
        Route::get('/dashboard', [MentorController::class, 'dashboard'])->name('dashboard');
        Route::post('/booking/{booking}/status', [BookingController::class, 'updateStatus'])->name('booking.status');
    });

    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });
});
