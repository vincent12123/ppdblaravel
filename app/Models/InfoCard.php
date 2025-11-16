<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InfoCard extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'bg_color',
        'icon_bg_color',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope untuk card aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk urutan
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
