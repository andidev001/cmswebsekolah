<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CarouselController extends Controller
{
    public function index()
    {
        return view('admin.carousels.index');
    }

    public function getData()
    {
        $carousels = Carousel::select(['id', 'image', 'title', 'subtitle', 'button_text', 'button_link', 'order_index', 'is_active', 'created_at'])
            ->orderBy('order_index', 'asc');

        return DataTables::of($carousels)
            ->addColumn('image_url', function ($row) {
                return $row->image_url;
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3072',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|url|max:255',
            'order_index' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active') ? true : false;

        if ($request->hasFile('image')) {
            $imageName = 'carousel_' . time() . '_' . rand(100, 999) . '.' . $request->image->extension();
            $request->image->storeAs('carousels', $imageName, 'public');
            $data['image'] = $imageName;
        }

        Carousel::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Slide hero berhasil ditambahkan.'
        ]);
    }

    public function show($id)
    {
        $carousel = Carousel::findOrFail($id);
        $carousel->append('image_url');
        return response()->json($carousel);
    }

    public function update(Request $request, $id)
    {
        $carousel = Carousel::findOrFail($id);

        $data = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:3072',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|url|max:255',
            'order_index' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active') ? true : false;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($carousel->image && Storage::disk('public')->exists('carousels/' . $carousel->image)) {
                Storage::disk('public')->delete('carousels/' . $carousel->image);
            }
            
            $imageName = 'carousel_' . time() . '_' . rand(100, 999) . '.' . $request->image->extension();
            $request->image->storeAs('carousels', $imageName, 'public');
            $data['image'] = $imageName;
        }

        $carousel->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Slide hero berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $carousel = Carousel::findOrFail($id);

        // Delete image file
        if ($carousel->image && Storage::disk('public')->exists('carousels/' . $carousel->image)) {
            Storage::disk('public')->delete('carousels/' . $carousel->image);
        }

        $carousel->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slide hero berhasil dihapus.'
        ]);
    }
}
