<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'applicant_id', 'type', 'file_path', 'is_verified', 'verification_notes'
    ];

    protected $casts = [ 'is_verified' => 'boolean' ];

    public function applicant() {
        return $this->belongsTo(Applicant::class);
    }
}
