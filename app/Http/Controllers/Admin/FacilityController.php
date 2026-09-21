<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{
    public function index()
    {
        return view('admin.facilities.index');
    }

    public function getData()
    {
        $facilities = Facility::select(['id', 'name', 'description', 'photo']);

        return DataTables::of($facilities)
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoName = time() . '_' . Str::slug($request->name) . '.' . $request->photo->extension();
            $request->photo->storeAs('facilities', $photoName, 'public');
            $data['photo'] = $photoName;
        }

        Facility::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Fasilitas berhasil ditambahkan.'
        ]);
    }

    public function show($id)
    {
        $facility = Facility::findOrFail($id);
        $facility->append('photo_url');
        return response()->json($facility);
    }

    public function update(Request $request, $id)
    {
        $facility = Facility::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($facility->photo && Storage::disk('public')->exists('facilities/' . $facility->photo)) {
                Storage::disk('public')->delete('facilities/' . $facility->photo);
            }
            $photoName = time() . '_' . Str::slug($request->name) . '.' . $request->photo->extension();
            $request->photo->storeAs('facilities', $photoName, 'public');
            $data['photo'] = $photoName;
        }

        $facility->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Fasilitas berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $facility = Facility::findOrFail($id);

        if ($facility->photo && Storage::disk('public')->exists('facilities/' . $facility->photo)) {
            Storage::disk('public')->delete('facilities/' . $facility->photo);
        }

        $facility->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fasilitas berhasil dihapus.'
        ]);
    }
}
