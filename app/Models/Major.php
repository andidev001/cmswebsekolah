<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'photo',
    ];

    public function getPhotoUrlAttribute()
    {
        if ($this->photo && file_exists(public_path('storage/majors/' . $this->photo))) {
            return asset('storage/majors/' . $this->photo);
        }

        $name = strtolower($this->name);
        if (str_contains($name, 'komputer') || str_contains($name, 'jaringan') || str_contains($name, 'rpl') || str_contains($name, 'tkj') || str_contains($name, 'software') || str_contains($name, 'informatika')) {
            return 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'mesin') || str_contains($name, 'otomotif') || str_contains($name, 'motor') || str_contains($name, 'mobil') || str_contains($name, 'tkr') || str_contains($name, 'tbsm')) {
            return 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($name, 'akuntansi') || str_contains($name, 'keuangan') || str_contains($name, 'bisnis') || str_contains($name, 'perkantoran') || str_contains($name, 'pemasaran')) {
            return 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=600&auto=format&fit=crop';
        }

        return 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=600&auto=format&fit=crop';
    }
}
