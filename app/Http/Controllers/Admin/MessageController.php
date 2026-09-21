<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MessageController extends Controller
{
    public function index()
    {
        return view('admin.messages.index');
    }

    public function getData()
    {
        $messages = Message::select(['id', 'name', 'email', 'subject', 'message', 'created_at']);

        return DataTables::of($messages)
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y H:i');
            })
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-info view-btn me-1" data-id="' . $row->id . '">
                        <i class="fa-regular fa-eye"></i> Detail
                    </button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">
                        <i class="fa-regular fa-trash-can"></i> Hapus
                    </button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show($id)
    {
        $message = Message::findOrFail($id);
        $message->date_formatted = $message->created_at->format('d M Y H:i');
        return response()->json($message);
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dihapus.'
        ]);
    }
}
