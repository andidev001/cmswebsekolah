<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AgendaController extends Controller
{
    public function index()
    {
        return view('admin.agendas.index');
    }

    public function getData()
    {
        $agendas = Agenda::select(['id', 'title', 'description', 'date', 'location', 'time']);

        return DataTables::of($agendas)
            ->editColumn('date', function ($row) {
                return $row->date->format('d M Y');
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'time' => 'nullable|string|max:100',
        ]);

        Agenda::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Agenda kegiatan berhasil ditambahkan.'
        ]);
    }

    public function show($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->date_formatted = $agenda->date->format('Y-m-d');
        return response()->json($agenda);
    }

    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'time' => 'nullable|string|max:100',
        ]);

        $agenda->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Agenda kegiatan berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return response()->json([
            'success' => true,
            'message' => 'Agenda kegiatan berhasil dihapus.'
        ]);
    }
}
