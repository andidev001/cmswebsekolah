<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;

    protected $table = 'alumni'; // explicitly override Laravel pluralization if necessary

    protected $fillable = [
        'name',
        'graduation_year',
        'tahun_ajaran',
        'job',
        'melanjutkan_sekolah',
        'phone',
        'email',
        'testimonial',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];
}
