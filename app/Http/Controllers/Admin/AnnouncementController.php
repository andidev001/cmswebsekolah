<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('admin.announcements.index');
    }

    public function getData()
    {
        $announcements = Announcement::select(['id', 'title', 'slug', 'content', 'date']);

        return DataTables::of($announcements)
            ->editColumn('date', function ($row) {
                return $row->date->format('d M Y');
            })
            ->editColumn('content', function ($row) {
                return Str::limit(strip_tags($row->content), 80);
            })
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-info edit-btn me-1" data-id="' . $row->id . '">
                        <i class="fa-regular fa-pen-to-square"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">
                        <i class="fa-regular fa-trash-can"></i> Hapus
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'required|date',
        ]);

        $data['slug'] = Str::slug($request->title) . '-' . uniqid();

        Announcement::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil ditambahkan.'
        ]);
    }

    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        // format date for input field
        $announcement->date_formatted = $announcement->date->format('Y-m-d');
        return response()->json($announcement);
    }

    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'required|date',
        ]);

        $data['slug'] = Str::slug($request->title) . '-' . $announcement->id;

        $announcement->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengumuman berhasil dihapus.'
        ]);
    }
}
