<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'photo',
    ];

    public function getPhotoUrlAttribute()
    {
        if ($this->photo && file_exists(public_path('storage/facilities/' . $this->photo))) {
            return asset('storage/facilities/' . $this->photo);
        }
        
        $name = strtolower($this->name);
        if (str_contains($name, 'komputer') || str_contains($name, 'lab') || str_contains($name, 'tkj')) {
            return 'https://images.unsplash.com/photo-1573164713988-8665fc963095?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'bengkel') || str_contains($name, 'praktik') || str_contains($name, 'tbsm') || str_contains($name, 'tkr')) {
            return 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'perpustakaan') || str_contains($name, 'perpus') || str_contains($name, 'buku')) {
            return 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=600&auto=format&fit=crop';
        }
        
        return 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=600&auto=format&fit=crop';
    }
}
