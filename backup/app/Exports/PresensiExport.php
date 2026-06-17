<?php

namespace App\Exports;

use App\Models\card;
use App\Models\marketing;
use Maatwebsite\Excel\Concerns\FromView;

use Illuminate\Contracts\View\View;

use App\Models\presensi;
use App\Models\store;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromCollection;

class PresensiExport implements FromView
{
    public function view(): View
    {
        $card = Card::all();
        $marketing = Marketing::all();
        $store = Store::where('id', auth()->user()->store_id)->first();
        // Ambil tanggal dari request jika ada
        $start_date = request()->input('start_date');
        $end_date = request()->input('end_date');

        // Ambil semua data untuk setiap kombinasi kode_hari dan tanggal (created_at)
        $presensiQuery = Presensi::where('store_id', auth()->user()->store_id);

        if ($start_date && $end_date) {
            $presensiQuery->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        }

        // Ambil semua data untuk setiap kombinasi kode_hari
        $presensiItems = $presensiQuery->orderBy('kode_hari')
            ->orderBy('created_at')
            ->get();

        // Ambil satu data untuk setiap kombinasi kode_hari
        $filteredPresensi = collect();
        $uniqueCombination = [];

        foreach ($presensiItems as $presensiItem) {
            // Buat kombinasi unik dari kode_hari dan tanggal
            $combinationKey = $presensiItem->kode_hari . '|' . $presensiItem->created_at->toDateString();

            // Tambahkan data ke koleksi jika kombinasi belum ada
            if (!in_array($combinationKey, $uniqueCombination)) {
                $filteredPresensi->push($presensiItem);
                $uniqueCombination[] = $combinationKey;
            }
        }

        return view('staf.export.presensi', [
            'presensis' => $filteredPresensi,
            'cards' => $card,
            'marketings' => $marketing,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'store' => $store->nama,
        ]);
    }
}


// class PresensiExport implements FromView
// {
//     public function view(): View
//     {
//         $store = Store::all();
//         $card = Card::all();
//         $marketing = Marketing::all();

//         // Ambil nilai unik dari kolom kode_hari
//         $uniqueKodeHari = Presensi::distinct('kode_hari')->pluck('kode_hari');

//         // Ambil satu data untuk setiap nilai unik pada kolom kode_hari
//         $filteredPresensi = collect();
        
//         // Ambil tanggal dari request atau gunakan tanggal hari ini sebagai default
//         $tanggal = Request::input('created_at', now()->toDateString());

//         foreach ($uniqueKodeHari as $kodeHari) {
//             // Tambahkan filter berdasarkan tanggal pada query Presensi
//             $presensiItem = Presensi::where('kode_hari', $kodeHari)
//                 ->whereDate('created_at', $tanggal)
//                 ->first();

//             $filteredPresensi->push($presensiItem);
//         }

//         return view('staf.export.presensi', [
//             'presensis' => $filteredPresensi,
//             'stores' => $store,
//             'cards' => $card,
//             'marketings' => $marketing,
//             'tanggal' => $tanggal, // Tambahkan variabel tanggal ke view jika diperlukan
//         ]);
//     }
// }

