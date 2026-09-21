<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    public function index()
    {
        return view('admin.achievements.index');
    }

    public function getData()
    {
        $achievements = Achievement::select(['id', 'title', 'student_name', 'date', 'photo']);

        return DataTables::of($achievements)
            ->addColumn('photo_preview', function ($row) {
                return '<img src="' . $row->photo_url . '" alt="Foto" class="rounded" width="60" height="40" style="object-fit: cover;">';
            })
            ->editColumn('date', function ($row) {
                return $row->date ? $row->date->format('d M Y') : '-';
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
            ->rawColumns(['photo_preview', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'student_name' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoName = time() . '_' . Str::slug($request->title) . '.' . $request->photo->extension();
            $request->photo->storeAs('achievements', $photoName, 'public');
            $data['photo'] = $photoName;
        }

        Achievement::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data prestasi siswa berhasil ditambahkan.'
        ]);
    }

    public function show($id)
    {
        $achievement = Achievement::findOrFail($id);
        if ($achievement->date) {
            $achievement->date_formatted = $achievement->date->format('Y-m-d');
        }
        $achievement->append('photo_url');
        return response()->json($achievement);
    }

    public function update(Request $request, $id)
    {
        $achievement = Achievement::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'student_name' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($achievement->photo && Storage::disk('public')->exists('achievements/' . $achievement->photo)) {
                Storage::disk('public')->delete('achievements/' . $achievement->photo);
            }
            $photoName = time() . '_' . Str::slug($request->title) . '.' . $request->photo->extension();
            $request->photo->storeAs('achievements', $photoName, 'public');
            $data['photo'] = $photoName;
        }

        $achievement->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data prestasi siswa berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $achievement = Achievement::findOrFail($id);

        if ($achievement->photo && Storage::disk('public')->exists('achievements/' . $achievement->photo)) {
            Storage::disk('public')->delete('achievements/' . $achievement->photo);
        }

        $achievement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data prestasi siswa berhasil dihapus.'
        ]);
    }
}
