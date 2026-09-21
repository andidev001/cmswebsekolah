<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_name',
        'slogan',
        'jenjang',
        'school_logo',
        'principal_name',
        'principal_speech',
        'principal_photo',
        'vision',
        'mission',
        'address',
        'email',
        'phone',
        'maps_iframe',
        'external_ppdb_link',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'theme',
        'whatsapp_number',
        'whatsapp_welcome_message',
        'ppdb_active',
        'ppdb_content',
        'ppdb_requirements',
        'ppdb_schedule',
    ];

    public function getSchoolLogoUrlAttribute()
    {
        if ($this->school_logo && file_exists(public_path('storage/settings/' . $this->school_logo))) {
            return asset('storage/settings/' . $this->school_logo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->school_name ?: 'School') . '&background=1e3a8a&color=fff&size=200&bold=true';
    }

    public function getPrincipalPhotoUrlAttribute()
    {
        if ($this->principal_photo && file_exists(public_path('storage/settings/' . $this->principal_photo))) {
            return asset('storage/settings/' . $this->principal_photo);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->principal_name ?: 'Principal') . '&background=1e3a8a&color=fff&size=200';
    }
}
