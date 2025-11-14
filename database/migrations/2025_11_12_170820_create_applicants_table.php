<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique(); // No registrasi
            $table->string('name'); // Nama
            $table->string('nisn')->unique(); // NISN
            $table->date('birth_date'); // Tanggal lahir
            $table->enum('gender', ['male', 'female']); // Jenis kelamin
            $table->string('email')->nullable(); // Email (opsional)
            $table->string('phone'); // No HP
            $table->string('parent_name'); // Nama orang tua/wali
            $table->string('parent_phone'); // No HP orang tua/wali
            $table->text('address'); // Alamat
            $table->string('origin_school'); // Asal sekolah
            $table->foreignId('major_choice_1')->constrained('majors'); // Pilihan 1
            $table->foreignId('major_choice_2')->nullable()->constrained('majors'); // Pilihan 2
            $table->foreignId('major_choice_3')->nullable()->constrained('majors'); // Pilihan 3
            $table->enum('status', ['registered', 'verified', 'accepted', 'rejected', 'registered_final'])->default('registered'); // Status
            $table->foreignId('assigned_major')->nullable()->constrained('majors'); // Jurusan diterima
            $table->timestamp('registered_at')->nullable(); // Waktu registrasi
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('applicants');
    }
};
