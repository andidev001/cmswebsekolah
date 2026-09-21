<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ExtracurricularController extends Controller
{
    public function index()
    {
        return view('admin.extracurriculars.index');
    }

    public function getData()
    {
        $ekskul = Extracurricular::select(['id', 'name', 'description', 'coach', 'photo']);

        return DataTables::of($ekskul)
            ->addColumn('photo_preview', function ($row) {
                return '<img src="' . $row->photo_url . '" alt="Foto" class="rounded" width="60" height="40" style="object-fit: cover;">';
            })
            ->editColumn('description', function ($row) {
                return Str::limit($row->description, 80);
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coach' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoName = time() . '_' . Str::slug($request->name) . '.' . $request->photo->extension();
            $request->photo->storeAs('extracurriculars', $photoName, 'public');
            $data['photo'] = $photoName;
        }

        Extracurricular::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Ekstrakurikuler berhasil ditambahkan.'
        ]);
    }

    public function show($id)
    {
        $ekskul = Extracurricular::findOrFail($id);
        $ekskul->append('photo_url');
        return response()->json($ekskul);
    }

    public function update(Request $request, $id)
    {
        $ekskul = Extracurricular::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coach' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($ekskul->photo && Storage::disk('public')->exists('extracurriculars/' . $ekskul->photo)) {
                Storage::disk('public')->delete('extracurriculars/' . $ekskul->photo);
            }
            $photoName = time() . '_' . Str::slug($request->name) . '.' . $request->photo->extension();
            $request->photo->storeAs('extracurriculars', $photoName, 'public');
            $data['photo'] = $photoName;
        }

        $ekskul->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Ekstrakurikuler berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $ekskul = Extracurricular::findOrFail($id);

        if ($ekskul->photo && Storage::disk('public')->exists('extracurriculars/' . $ekskul->photo)) {
            Storage::disk('public')->delete('extracurriculars/' . $ekskul->photo);
        }

        $ekskul->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ekstrakurikuler berhasil dihapus.'
        ]);
    }
}
