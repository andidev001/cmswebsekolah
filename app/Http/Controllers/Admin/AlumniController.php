<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

class AlumniController extends Controller
{
    public function index()
    {
        return view('admin.alumni.index');
    }

    public function getData()
    {
        $alumni = Alumni::select(['id', 'name', 'graduation_year', 'tahun_ajaran', 'job', 'melanjutkan_sekolah', 'phone', 'email', 'testimonial', 'is_approved', 'created_at']);

        return DataTables::of($alumni)
            ->addColumn('action', function ($row) {
                $approveBtn = $row->is_approved 
                    ? '<button class="btn btn-sm btn-warning toggle-approve-btn me-1" data-id="' . $row->id . '"><i class="fa-solid fa-xmark"></i> Tolak</button>' 
                    : '<button class="btn btn-sm btn-success toggle-approve-btn me-1" data-id="' . $row->id . '"><i class="fa-solid fa-check"></i> Setuju</button>';
                
                return $approveBtn . '
                    <button class="btn btn-sm btn-info edit-btn me-1" data-id="' . $row->id . '">
                        <i class="fa-regular fa-pen-to-square"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '">
                        <i class="fa-regular fa-trash-can"></i> Hapus
                    </button>
                ';
            })
            ->editColumn('is_approved', function ($row) {
                return $row->is_approved 
                    ? '<span class="badge bg-success">Disetujui</span>' 
                    : '<span class="badge bg-warning">Menunggu</span>';
            })
            ->rawColumns(['action', 'is_approved'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:1970|max:' . (date('Y') + 1),
            'tahun_ajaran' => 'nullable|string|max:50',
            'job' => 'nullable|string|max:255',
            'melanjutkan_sekolah' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'testimonial' => 'nullable|string',
            'is_approved' => 'nullable|boolean',
        ]);

        Alumni::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data alumni berhasil ditambahkan.'
        ]);
    }

    public function show($id)
    {
        $alumni = Alumni::findOrFail($id);
        return response()->json($alumni);
    }

    public function update(Request $request, $id)
    {
        $alumni = Alumni::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:1970|max:' . (date('Y') + 1),
            'tahun_ajaran' => 'nullable|string|max:50',
            'job' => 'nullable|string|max:255',
            'melanjutkan_sekolah' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'testimonial' => 'nullable|string',
            'is_approved' => 'nullable|boolean',
        ]);

        $alumni->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data alumni berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data alumni berhasil dihapus.'
        ]);
    }

    public function toggleApprove($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->is_approved = !$alumni->is_approved;
        $alumni->save();

        return response()->json([
            'success' => true,
            'message' => 'Status persetujuan alumni berhasil diubah.'
        ]);
    }

    public function export()
    {
        $alumni = Alumni::orderBy('graduation_year', 'desc')->orderBy('name', 'asc')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Alumni');

        // ── HEADER ROW ──────────────────────────────────────────────────────────
        $headers = ['No', 'Nama Alumni', 'Tahun Lulus', 'Tahun Ajaran',
                    'Pekerjaan / Aktivitas', 'Melanjutkan Sekolah',
                    'No. Telp', 'Email', 'Testimoni', 'Status'];
        $colLetters = ['A','B','C','D','E','F','G','H','I','J'];

        foreach ($headers as $index => $header) {
            $sheet->setCellValue($colLetters[$index] . '1', $header);
        }

        // Style header row
        $headerStyle = [
            'font' => [
                'bold'  => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size'  => 11,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1E3A8A'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => false,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['argb' => 'FFBFDBFE'],
                ],
            ],
        ];
        $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);
        $sheet->getRowDimension(1)->setRowHeight(22);

        // Freeze header row
        $sheet->freezePane('A2');

        // ── DATA ROWS ────────────────────────────────────────────────────────────
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['argb' => 'FFE2E8F0'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        foreach ($alumni as $key => $item) {
            $row = $key + 2;
            $sheet->setCellValue('A' . $row, $key + 1);
            $sheet->setCellValue('B' . $row, $item->name);
            $sheet->setCellValue('C' . $row, $item->graduation_year);
            $sheet->setCellValue('D' . $row, $item->tahun_ajaran ?? '-');
            $sheet->setCellValue('E' . $row, $item->job ?? '-');
            $sheet->setCellValue('F' . $row, $item->melanjutkan_sekolah ?? '-');
            $sheet->setCellValue('G' . $row, $item->phone ?? '-');
            $sheet->setCellValue('H' . $row, $item->email ?? '-');
            $sheet->setCellValue('I' . $row, $item->testimonial ?? '-');
            $sheet->setCellValue('J' . $row, $item->is_approved ? 'Disetujui' : 'Menunggu');

            // Alternate row color
            if ($key % 2 === 0) {
                $sheet->getStyle('A'.$row.':J'.$row)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF8FAFF');
            }
        }

        // Apply border to all data rows
        if ($alumni->count() > 0) {
            $lastRow = $alumni->count() + 1;
            $sheet->getStyle('A2:J' . $lastRow)->applyFromArray($dataStyle);

            // Center align: No, Tahun Lulus, Status columns
            $sheet->getStyle('A2:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('C2:C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('D2:D' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('J2:J' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Color "Disetujui" / "Menunggu" in Status column
            foreach ($alumni as $key => $item) {
                $row = $key + 2;
                if ($item->is_approved) {
                    $sheet->getStyle('J'.$row)->getFont()->getColor()->setARGB('FF166534');
                    $sheet->getStyle('J'.$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDCFCE7');
                } else {
                    $sheet->getStyle('J'.$row)->getFont()->getColor()->setARGB('FF92400E');
                    $sheet->getStyle('J'.$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFEF3C7');
                }
            }
        }

        // ── COLUMN WIDTHS ───────────────────────────────────────────────────────
        $colWidths = [
            'A' => 5,   // No
            'B' => 30,  // Nama Alumni
            'C' => 12,  // Tahun Lulus
            'D' => 14,  // Tahun Ajaran
            'E' => 28,  // Pekerjaan
            'F' => 28,  // Melanjutkan Sekolah
            'G' => 16,  // No. Telp
            'H' => 28,  // Email
            'I' => 40,  // Testimoni
            'J' => 12,  // Status
        ];
        foreach ($colWidths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        // ── DOCUMENT PROPERTIES ─────────────────────────────────────────────────
        $spreadsheet->getProperties()
            ->setTitle('Daftar Alumni')
            ->setSubject('Database Alumni')
            ->setDescription('Diekspor dari sistem CMS Sekolah');

        // ── STREAM OUTPUT ───────────────────────────────────────────────────────
        $filename = 'daftar_alumni_' . date('Y-m-d_H-i-s') . '.xlsx';

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }
}
