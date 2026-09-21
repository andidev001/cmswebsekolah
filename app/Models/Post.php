<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'content',
        'image',
        'status',
        'views',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('storage/posts/' . $this->image))) {
            return asset('storage/posts/' . $this->image);
        }
        
        $title = strtolower($this->title);
        if (str_contains($title, 'wisuda') || str_contains($title, 'pelepasan')) {
            return 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($title, 'mou') || str_contains($title, 'kerjasama') || str_contains($title, 'industri')) {
            return 'https://images.unsplash.com/photo-1521791136064-7986c2959d43?q=80&w=600&auto=format&fit=crop';
        }
        if (str_contains($title, 'lks') || str_contains($title, 'juara') || str_contains($title, 'kompetensi')) {
            return 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=600&auto=format&fit=crop';
        }
        
        return 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?q=80&w=600&auto=format&fit=crop';
    }
}
