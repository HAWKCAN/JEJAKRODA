<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\RentalOwner;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ManagerReportController extends Controller
{
    public function index(Request $request)
    {
        $owner = RentalOwner::where('user_id', auth()->id())->firstOrFail();

        $query = $this->buildFilteredQuery($owner, $request);
        $bookings = $query->latest()->get();

        $totalSubtotal = $bookings->sum('subtotal');
        $totalFee      = $bookings->sum('platform_fee_amount');
        $totalBersih   = $totalSubtotal - $totalFee;

        $chartData = collect(range(1, 12))->map(function ($month) use ($owner) {
            return Booking::whereHas('vehicle', fn($q) => $q->where('rental_owner_id', $owner->id))
                ->whereHas('payment', fn($q) => $q->where('status', 'verified'))
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', now()->year)
                ->selectRaw('SUM(subtotal - platform_fee_amount) as net')
                ->value('net') ?? 0;
        })->values();

        return view('manager.reports.index', compact(
            'bookings',
            'totalSubtotal',
            'totalFee',
            'totalBersih',
            'chartData'
        ));
    }

    public function export(Request $request)
    {
        $owner = RentalOwner::where('user_id', auth()->id())->firstOrFail();

        // Query sama persis dengan index() agar hasil export konsisten
        // dengan apa yang sedang ditampilkan di halaman laporan
        $bookings = $this->buildFilteredQuery($owner, $request)->latest()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Pendapatan');

        $headers = [
            'ID Booking',
            'Nama Penyewa',
            'Kendaraan',
            'Plat Nomor',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Total Hari',
            'Subtotal (Rp)',
            'Fee Platform 5% (Rp)',
            'Pendapatan Bersih (Rp)',
            'Metode Bayar',
            'Tanggal Booking',
        ];
        $sheet->fromArray($headers, null, 'A1');

        // Styling header: bold, putih, background indigo
        $lastCol = Coordinate::stringFromColumnIndex(count($headers));
        $headerRange = 'A1:' . $lastCol . '1';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(22);

        // Tulis baris data
        $row = 2;
        foreach ($bookings as $booking) {
            $bersih = $booking->subtotal - $booking->platform_fee_amount;

            $sheet->fromArray([
                $booking->id,
                $booking->user->name            ?? '-',
                $booking->vehicle->name          ?? '-',
                $booking->vehicle->plate_number  ?? '-',
                optional($booking->start_date)->format('d/m/Y'),
                optional($booking->end_date)->format('d/m/Y'),
                $booking->total_days,
                $booking->subtotal,
                $booking->platform_fee_amount,
                $bersih,
                $booking->payment->method        ?? '-',
                $booking->created_at->format('d/m/Y H:i'),
            ], null, 'A' . $row);

            $row++;
        }

        $lastRow = $row - 1;

        // Baris total di bawah data (kalau ada data)
        if ($bookings->count() > 0) {
            $totalRow = $row;
            $sheet->setCellValue('G' . $totalRow, 'TOTAL');
            $sheet->setCellValue('H' . $totalRow, '=SUM(H2:H' . $lastRow . ')');
            $sheet->setCellValue('I' . $totalRow, '=SUM(I2:I' . $lastRow . ')');
            $sheet->setCellValue('J' . $totalRow, '=SUM(J2:J' . $lastRow . ')');

            $sheet->getStyle('G' . $totalRow . ':J' . $totalRow)->applyFromArray([
                'font' => ['bold' => true],
                'borders' => ['top' => ['borderStyle' => Border::BORDER_THIN]],
            ]);
            $lastRow = $totalRow;
        }

        // Format angka kolom Subtotal, Fee, Bersih sebagai Rupiah
        if ($bookings->count() > 0) {
            $sheet->getStyle('H2:J' . $lastRow)
                ->getNumberFormat()
                ->setFormatCode('#,##0');
        }

        // Auto width untuk semua kolom
        foreach (range('A', 'L') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border tipis untuk seluruh tabel data (header + isi)
        $sheet->getStyle('A1:L' . $lastRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E2E8F0']]],
        ]);

        $filename = 'laporan-pendapatan-' . now()->format('Y-m-d') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }

    /**
     * Bangun query booking terfilter, dipakai bersama oleh index() dan export()
     * agar hasil tampilan dan hasil export selalu konsisten.
     */
    private function buildFilteredQuery(RentalOwner $owner, Request $request)
    {
        $query = Booking::with(['payment', 'vehicle', 'user'])
            ->whereHas('vehicle', function ($q) use ($owner) {
                $q->where('rental_owner_id', $owner->id);
            })
            ->whereHas('payment', function ($q) {
                $q->where('status', 'verified');
            });

        $filter = $request->input('filter', 'all');
        if ($filter === 'daily') {
            $query->whereDate('created_at', today());
        } elseif ($filter === 'monthly') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        return $query;
    }
}