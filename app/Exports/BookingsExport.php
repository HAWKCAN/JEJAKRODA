<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Booking::with(['user', 'vehicle'])
            ->where('status', 'completed');

        // Terapkan filter yang sama dengan halaman laporan
        if (!empty($this->filters['filter'])) {
            if ($this->filters['filter'] === 'daily') {
                $query->whereDate('created_at', today());
            } elseif ($this->filters['filter'] === 'monthly') {
                $query->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
            }
        }

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('created_at', [
                $this->filters['start_date'] . ' 00:00:00',
                $this->filters['end_date']   . ' 23:59:59',
            ]);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID Booking',
            'Nama Penyewa',
            'Kendaraan',
            'Plat Nomor',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Total Hari',
            'Subtotal (Rp)',
            'Fee Platform 5% (Rp)',
            'Total Bersih (Rp)',
            'Tanggal Booking',
        ];
    }

    public function map($booking): array
    {
        return [
            $booking->id,
            $booking->user->name,
            $booking->vehicle->name,
            $booking->vehicle->plate_number,
            $booking->start_date->format('d/m/Y'),
            $booking->end_date->format('d/m/Y'),
            $booking->total_days,
            number_format($booking->subtotal, 0, ',', '.'),
            number_format($booking->platform_fee_amount, 0, ',', '.'),
            number_format($booking->total_price, 0, ',', '.'),
            $booking->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Baris pertama (heading) dibold
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}