<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'student_name',
        'date',
        'photo',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function getPhotoUrlAttribute()
    {
        if ($this->photo && file_exists(public_path('storage/achievements/' . $this->photo))) {
            return asset('storage/achievements/' . $this->photo);
        }
        
        $title = strtolower($this->title);
        if (str_contains($title, 'futsal') || str_contains($title, 'bola') || str_contains($title, 'sepak')) {
            return 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=600&auto=format&fit=crop';
        }
        
        return 'https://images.unsplash.com/photo-1518063319789-7217e6706b04?q=80&w=600&auto=format&fit=crop';
    }
}
