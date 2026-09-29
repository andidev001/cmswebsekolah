<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DownloadController extends Controller
{
    public function index()
    {
        return view('admin.downloads.index');
    }

    public function getData()
    {
        $downloads = Download::query()->latest();
        
        return DataTables::of($downloads)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<div class="btn-group" role="group">';
                $btn .= '<button type="button" class="btn btn-sm btn-info edit-btn" data-id="'.$row->id.'"><i class="fa-solid fa-pen-to-square"></i></button>';
                $btn .= '<button type="button" class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'"><i class="fa-solid fa-trash"></i></button>';
                $btn .= '</div>';
                return $btn;
            })
            ->addColumn('file_link', function($row){
                return '<a href="'.asset('storage/downloads/'.$row->file_path).'" target="_blank" class="btn btn-sm btn-primary"><i class="fa-solid fa-download me-1"></i> Lihat / Unduh</a>';
            })
            ->rawColumns(['action', 'file_link'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf|max:10240', // Max 10MB PDF
        ], [
            'file.required' => 'File PDF wajib diunggah.',
            'file.mimes' => 'File harus berupa PDF.',
            'file.max' => 'Ukuran file maksimal 10MB.'
        ]);

        $fileName = time() . '_' . str_replace(' ', '_', $request->file('file')->getClientOriginalName());
        $request->file('file')->storeAs('downloads', $fileName, 'public');

        Download::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $fileName,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data unduhan berhasil ditambahkan.'
        ]);
    }

    public function show($id)
    {
        $download = Download::findOrFail($id);
        return response()->json($download);
    }

    public function update(Request $request, $id)
    {
        $download = Download::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ], [
            'file.mimes' => 'File harus berupa PDF.',
            'file.max' => 'Ukuran file maksimal 10MB.'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('file')) {
            if ($download->file_path && Storage::disk('public')->exists('downloads/' . $download->file_path)) {
                Storage::disk('public')->delete('downloads/' . $download->file_path);
            }
            $fileName = time() . '_' . str_replace(' ', '_', $request->file('file')->getClientOriginalName());
            $request->file('file')->storeAs('downloads', $fileName, 'public');
            $data['file_path'] = $fileName;
        }

        $download->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data unduhan berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $download = Download::findOrFail($id);
        if ($download->file_path && Storage::disk('public')->exists('downloads/' . $download->file_path)) {
            Storage::disk('public')->delete('downloads/' . $download->file_path);
        }
        $download->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data unduhan berhasil dihapus.'
        ]);
    }
}
