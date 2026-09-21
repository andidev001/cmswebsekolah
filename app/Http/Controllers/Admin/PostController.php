<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.posts.index', compact('categories'));
    }

    public function getData()
    {
        $posts = Post::with('category')->select(['posts.*']);

        return DataTables::of($posts)
            ->addColumn('category_name', function ($row) {
                return $row->category->name ?? '-';
            })
            ->addColumn('thumbnail', function ($row) {
                return '<img src="' . $row->image_url . '" alt="Image" class="rounded" width="60" height="40" style="object-fit: cover;">';
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'published') {
                    return '<span class="badge bg-success">Published</span>';
                }
                return '<span class="badge bg-warning">Draft</span>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
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
            ->rawColumns(['thumbnail', 'status', 'action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data['slug'] = Str::slug($request->title) . '-' . uniqid();
        $data['user_id'] = Auth::id();
        $data['views'] = 0;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $request->image->extension();
            $request->image->storeAs('posts', $imageName, 'public');
            $data['image'] = $imageName;
        }

        Post::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil ditambahkan.'
        ]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $post->append('image_url');
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data['slug'] = Str::slug($request->title) . '-' . $post->id;

        if ($request->hasFile('image')) {
            if ($post->image && Storage::disk('public')->exists('posts/' . $post->image)) {
                Storage::disk('public')->delete('posts/' . $post->image);
            }
            $imageName = time() . '_' . Str::slug($request->title) . '.' . $request->image->extension();
            $request->image->storeAs('posts', $imageName, 'public');
            $data['image'] = $imageName;
        }

        $post->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image && Storage::disk('public')->exists('posts/' . $post->image)) {
            Storage::disk('public')->delete('posts/' . $post->image);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dihapus.'
        ]);
    }
}
