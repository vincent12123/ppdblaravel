<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;
use Filament\Facades\Filament;

// Landing Page Routes
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/jurusan', [LandingController::class, 'majors'])->name('majors');
Route::get('/jurusan/{slug}', [LandingController::class, 'majorDetail'])->name('major.detail');
Route::get('/pengumuman', [LandingController::class, 'announcements'])->name('announcements');
Route::get('/pengumuman/{id}', [LandingController::class, 'announcementDetail'])->name('announcement.detail');

// Registration Routes
Route::get('/pendaftaran', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/pendaftaran', [RegistrationController::class, 'store'])->name('registration.store');
Route::get('/pendaftaran/sukses/{registration_number}', [RegistrationController::class, 'success'])->name('registration.success');

// Check Status Routes
Route::get('/cek-status', [RegistrationController::class, 'checkStatus'])->name('registration.checkStatus');
Route::post('/cek-status', [RegistrationController::class, 'showStatus'])->name('registration.showStatus');

// Login redirect to Filament admin
Route::get('/login', function () {
    return redirect(Filament::getLoginUrl());
})->name('login');
