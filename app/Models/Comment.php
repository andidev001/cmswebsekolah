<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'name',
        'email',
        'body',
        'is_approved',
        'admin_reply',
        'is_read',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
