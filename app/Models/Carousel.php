<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    use HasFactory;

    protected $table = 'carousels';

    protected $fillable = [
        'image',
        'title',
        'subtitle',
        'button_text',
        'button_link',
        'order_index',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_index' => 'integer',
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image && file_exists(public_path('storage/carousels/' . $this->image))) {
            return asset('storage/carousels/' . $this->image);
        }
        return 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1200&q=80';
    }
}
