<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'registration_number', 'name', 'nisn', 'birth_date', 'gender', 'email', 'phone', 'address',
        'origin_school', 'major_choice_1', 'major_choice_2', 'major_choice_3',
        'assigned_major', 'status', 'rapor_average',
        'documents_verified', 'payment_verified', 'registered_at'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'documents_verified' => 'boolean',
        'payment_verified' => 'boolean',
        'registered_at' => 'datetime',
    ];

    // Relasi ke dokumen pendaftar
    public function documents() {
        return $this->hasMany(Document::class);
    }

    // Relasi ke pilihan 1/2/3 jurusan
    public function majorChoice1() {
        return $this->belongsTo(Major::class, 'major_choice_1');
    }
    public function majorChoice2() {
        return $this->belongsTo(Major::class, 'major_choice_2');
    }
    public function majorChoice3() {
        return $this->belongsTo(Major::class, 'major_choice_3');
    }
    public function assignedMajor() {
        return $this->belongsTo(Major::class, 'assigned_major');
    }

    // Nomor registrasi otomatis
    public static function generateRegistrationNumber() {
        $year = date('Y');
        $count = static::whereYear('created_at', $year)->count() + 1;
        return 'REG' . $year . str_pad($count, 5, '0', STR_PAD_LEFT);
    }
}
