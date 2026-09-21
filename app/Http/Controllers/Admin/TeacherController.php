<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index()
    {
        return view('admin.teachers.index');
    }

    public function getData()
    {
        $teachers = Teacher::select(['id', 'nip', 'name', 'position', 'photo', 'is_active']);

        return DataTables::of($teachers)
            ->addColumn('photo_preview', function ($row) {
                return '<img src="' . $row->photo_url . '" alt="Foto" class="rounded-circle" width="45" height="45" style="object-fit: cover;">';
            })
            ->editColumn('is_active', function ($row) {
                if ($row->is_active) {
                    return '<span class="badge bg-success">Aktif</span>';
                }
                return '<span class="badge bg-danger">Non-Aktif</span>';
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
            ->rawColumns(['photo_preview', 'is_active', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => 'nullable|string|max:50',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable|in:0,1,true,false',
        ]);

        $data['is_active'] = $request->has('is_active') ? true : false;

        if ($request->hasFile('photo')) {
            $photoName = time() . '_' . Str::slug($request->name) . '.' . $request->photo->extension();
            $request->photo->storeAs('teachers', $photoName, 'public');
            $data['photo'] = $photoName;
        }

        Teacher::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil ditambahkan.'
        ]);
    }

    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->append('photo_url');
        return response()->json($teacher);
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $data = $request->validate([
            'nip' => 'nullable|string|max:50',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'nullable',
        ]);

        $data['is_active'] = $request->has('is_active') ? true : false;

        if ($request->hasFile('photo')) {
            if ($teacher->photo && Storage::disk('public')->exists('teachers/' . $teacher->photo)) {
                Storage::disk('public')->delete('teachers/' . $teacher->photo);
            }
            $photoName = time() . '_' . Str::slug($request->name) . '.' . $request->photo->extension();
            $request->photo->storeAs('teachers', $photoName, 'public');
            $data['photo'] = $photoName;
        }

        $teacher->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);

        if ($teacher->photo && Storage::disk('public')->exists('teachers/' . $teacher->photo)) {
            Storage::disk('public')->delete('teachers/' . $teacher->photo);
        }

        $teacher->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil dihapus.'
        ]);
    }
}
