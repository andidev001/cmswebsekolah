<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'photo',
        'coach',
    ];

    public function getPhotoUrlAttribute()
    {
        if ($this->photo && file_exists(public_path('storage/extracurriculars/' . $this->photo))) {
            return asset('storage/extracurriculars/' . $this->photo);
        }
        
        $name = strtolower($this->name);
        if (str_contains($name, 'pramuka') || str_contains($name, 'scout')) {
            return 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'paskibra') || str_contains($name, 'bendera')) {
            return 'https://images.unsplash.com/photo-1594495894542-a46cc73e081a?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'hadroh') || str_contains($name, 'rohis') || str_contains($name, 'islam')) {
            return 'https://images.unsplash.com/photo-1564507592333-c60657eea523?q=80&w=600&auto=format&fit=crop';
        }
        
        return 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?q=80&w=600&auto=format&fit=crop';
    }
}
