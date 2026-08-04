<?php

namespace App\Exports;

use App\Models\presensi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PresensiKartuExport implements FromCollection, WithHeadings, WithMapping
{
    protected $storeId;
    protected $startDate;
    protected $endDate;

    public function __construct($storeId, $startDate = null, $endDate = null)
    {
        $this->storeId = $storeId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = presensi::with(['card', 'marketing'])
            ->where('store_id', $this->storeId);

        if ($this->startDate && $this->endDate) {
            $query->whereDate('created_at', '>=', $this->startDate)
                ->whereDate('created_at', '<=', $this->endDate);
        } else {
            $query->whereDate('created_at', Carbon::today());
        }

        return $query->orderByDesc('created_at')->get();
    }

    public function headings(): array
    {
        return [
            'Waktu',
            'Tanggal',
            'Sumber',
            'ID Kartu',
            'NIK',
            'Nama',
            'Asal',
            'Jenis Kelamin',
            'PO',
            'Bus',
            'Total Belanja',
            'Marketing',
            'Keterangan',
            'Kode Presensi',
            'Status Approve',
            'Status Klaim',
        ];
    }

    public function map($row): array
    {
        return [
            $row->waktu,
            $row->tgl,
            $row->is_manual ? 'Manual' : 'RFID',
            $row->card->nomor ?? '',
            $row->card->nik ?? '',
            $row->card->nama ?? '',
            $row->card->asal ?? '',
            $row->card->jk ?? '',
            $row->po,
            $row->bus,
            $row->belanja,
            $row->marketing->nama ?? '',
            $row->ket,
            $row->kode_hari,
            $row->status_approve == 0 ? 'Not Approve' : 'Approved',
            $row->reward == 0 ? 'Belum Klaim' : 'Sudah Klaim',
        ];
    }
}
