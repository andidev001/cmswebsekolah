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

    public function markNotificationAsRead(\Illuminate\Http\Request $request)
    {
        $type = $request->query('type');
        $id = $request->query('id');

        if ($type === 'message') {
            Message::where('id', $id)->update(['is_read' => true]);
            return redirect()->route('admin.messages');
        } elseif ($type === 'comment') {
            \App\Models\Comment::where('id', $id)->update(['is_read' => true]);
            return redirect()->route('admin.comments');
        }

        return redirect()->back();
    }
}
