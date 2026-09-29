<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CommentController extends Controller
{
    public function index()
    {
        return view('admin.comments.index');
    }

    public function getData()
    {
        $comments = Comment::with('post')->latest();
        
        return DataTables::of($comments)
            ->addIndexColumn()
            ->addColumn('post_title', function($row){
                return $row->post ? $row->post->title : 'N/A';
            })
            ->addColumn('status', function($row){
                if($row->is_approved) {
                    return '<span class="badge bg-success">Disetujui</span>';
                }
                return '<span class="badge bg-warning text-dark">Menunggu</span>';
            })
            ->addColumn('action', function($row){
                $btn = '<div class="btn-group" role="group">';
                if($row->is_approved) {
                    $btn .= '<button type="button" class="btn btn-sm btn-warning toggle-btn" data-id="'.$row->id.'" title="Sembunyikan"><i class="fa-solid fa-eye-slash"></i></button>';
                } else {
                    $btn .= '<button type="button" class="btn btn-sm btn-success toggle-btn" data-id="'.$row->id.'" title="Setujui"><i class="fa-solid fa-check"></i></button>';
                }
                $btn .= '<button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'" title="Hapus"><i class="fa-solid fa-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function toggleApprove($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->is_approved = !$comment->is_approved;
        $comment->save();

        return response()->json([
            'success' => true,
            'message' => 'Status komentar berhasil diubah.'
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dihapus.'
        ]);
    }
}
