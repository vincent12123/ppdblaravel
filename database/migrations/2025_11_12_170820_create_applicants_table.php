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
            $table->string('email')->unique(); // Email
            $table->string('phone'); // No HP
            $table->text('address'); // Alamat
            $table->string('origin_school'); // Asal sekolah
            $table->foreignId('major_choice_1')->constrained('majors'); // Pilihan 1
            $table->foreignId('major_choice_2')->nullable()->constrained('majors'); // Pilihan 2
            $table->foreignId('major_choice_3')->nullable()->constrained('majors'); // Pilihan 3
            $table->enum('status', ['registered', 'verified', 'accepted', 'rejected', 'registered_final'])->default('registered'); // Status
            $table->foreignId('assigned_major')->nullable()->constrained('majors'); // Jurusan diterima
            $table->decimal('rapor_average', 3, 2)->nullable(); // Nilai rapor rata-rata
            $table->boolean('documents_verified')->default(false); // Status verifikasi dokumen
            $table->boolean('payment_verified')->default(false); // Status pembayaran
            $table->timestamp('registered_at')->nullable(); // Waktu registrasi
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('applicants');
    }
};
