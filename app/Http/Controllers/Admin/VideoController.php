<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VideoController extends Controller
{
    public function index()
    {
        return view('admin.videos.index');
    }

    public function getData()
    {
        $videos = Video::query()->latest();
        
        return DataTables::of($videos)
            ->addIndexColumn()
            ->addColumn('thumbnail', function($row){
                return '<img src="https://img.youtube.com/vi/'.$row->youtube_id.'/mqdefault.jpg" alt="Thumbnail" class="img-thumbnail" style="width: 120px;">';
            })
            ->addColumn('status', function($row){
                if($row->is_active) {
                    return '<span class="badge bg-success">Aktif</span>';
                }
                return '<span class="badge bg-secondary">Nonaktif</span>';
            })
            ->addColumn('action', function($row){
                $btn = '<div class="btn-group" role="group">';
                
                if($row->is_active) {
                    $btn .= '<button type="button" class="btn btn-sm btn-warning toggle-status" data-id="'.$row->id.'" title="Nonaktifkan"><i class="fa-solid fa-eye-slash"></i></button>';
                } else {
                    $btn .= '<button type="button" class="btn btn-sm btn-success toggle-status" data-id="'.$row->id.'" title="Aktifkan"><i class="fa-solid fa-eye"></i></button>';
                }
                
                $btn .= '<button type="button" class="btn btn-sm btn-info edit-btn" data-id="'.$row->id.'" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>';
                $btn .= '<button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'" title="Hapus"><i class="fa-solid fa-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['thumbnail', 'status', 'action'])
            ->make(true);
    }

    private function getYoutubeId($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $url, $match);
        return isset($match[1]) ? $match[1] : null;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|url',
        ], [
            'youtube_url.url' => 'Format URL YouTube tidak valid.'
        ]);

        $youtube_id = $this->getYoutubeId($request->youtube_url);
        if (!$youtube_id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menemukan ID Video dari URL YouTube yang diberikan.'
            ], 422);
        }

        Video::create([
            'title' => $request->title,
            'youtube_id' => $youtube_id,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Video berhasil ditambahkan.'
        ]);
    }

    public function show($id)
    {
        $video = Video::findOrFail($id);
        $video->youtube_url = 'https://www.youtube.com/watch?v=' . $video->youtube_id;
        return response()->json($video);
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|url',
        ]);

        $youtube_id = $this->getYoutubeId($request->youtube_url);
        if (!$youtube_id) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menemukan ID Video dari URL YouTube yang diberikan.'
            ], 422);
        }

        $video->update([
            'title' => $request->title,
            'youtube_id' => $youtube_id,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Video berhasil diperbarui.'
        ]);
    }

    public function toggleStatus($id)
    {
        $video = Video::findOrFail($id);
        $video->is_active = !$video->is_active;
        $video->save();

        return response()->json([
            'success' => true,
            'message' => 'Status video berhasil diubah.'
        ]);
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $video->delete();

        return response()->json([
            'success' => true,
            'message' => 'Video berhasil dihapus.'
        ]);
    }
}
