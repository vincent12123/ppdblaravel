<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['foto', 'ijazah', 'kartu_keluarga', 'akta_kelahiran', 'rapor']); // Jenis dokumen
            $table->string('file_path'); // Path file upload
            $table->boolean('is_verified')->default(false); // Status verifikasi
            $table->text('verification_notes')->nullable(); // Catatan verifikasi
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('documents');
    }
};
