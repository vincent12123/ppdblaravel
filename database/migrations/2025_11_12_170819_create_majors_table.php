<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama jurusan
            $table->string('slug')->unique(); // Slug jurusan (universal)
            $table->text('description'); // Deskripsi jurusan
            $table->text('facilities')->nullable(); // Fasilitas
            $table->text('career_prospects')->nullable(); // Prospek karir
            $table->integer('quota')->default(30); // Kuota pendaftaran
            $table->integer('duration_years')->default(3); // Lama studi (tahun)
            $table->boolean('is_active')->default(true); // Status aktif
            $table->string('icon')->nullable(); // Ikon
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('majors');
    }
};
