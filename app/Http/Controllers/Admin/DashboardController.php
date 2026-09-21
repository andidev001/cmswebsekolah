<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Extracurricular;
use App\Models\Facility;
use App\Models\Post;
use App\Models\Achievement;
use App\Models\Alumni;
use App\Models\Message;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'teachers' => Teacher::count(),
            'ekskul' => Extracurricular::count(),
            'facilities' => Facility::count(),
            'posts' => Post::count(),
            'achievements' => Achievement::count(),
            'alumni' => Alumni::count(),
            'messages' => Message::count(),
        ];

        $recent_messages = Message::latest()->limit(5)->get();
        $recent_posts = Post::with('category')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_messages', 'recent_posts'));
    }
}
