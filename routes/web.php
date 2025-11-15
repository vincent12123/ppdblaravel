<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use Filament\Facades\Filament;

// Landing Page Routes
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Chatbot AI proxy (CSRF-protected)
Route::post('/chat-ai', [ChatbotController::class, 'handleChat'])->name('chat.ai');
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

// Document Download Route (untuk admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/documents/{document}/download', function ($id) {
        $document = \App\Models\Document::findOrFail($id);
        $filePath = storage_path('app/public/' . $document->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($filePath, basename($document->file_path));
    })->name('documents.download');
});

// Login redirect to Filament admin
Route::get('/login', function () {
    return redirect(Filament::getLoginUrl());
})->name('login');
