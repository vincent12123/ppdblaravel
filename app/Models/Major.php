<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Major extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'facilities',
        'career_prospects', 'quota', 'duration_years', 'is_active', 'icon'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot method untuk auto-generate slug dari name jika belum ada
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($major) {
            if (empty($major->slug)) {
                $major->slug = Str::slug($major->name);
            }
        });

        static::updating(function ($major) {
            if (empty($major->slug) && !empty($major->name)) {
                $major->slug = Str::slug($major->name);
            }
        });
    }

    public function applicants() // relasi ke pendaftar jurusan
    {
        return $this->hasMany(Applicant::class, 'assigned_major');
    }
}
