<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreklaimRequest;
use App\Http\Requests\UpdateklaimRequest;
use App\Models\card;
use App\Models\klaim;
use App\Models\marketing;
use App\Models\presensi;
use App\Models\reward;
use App\Models\store;

class KlaimController extends Controller
{
   
    public function klaim_presensi()
    {
        $db = store::where('id', auth()->user()->store_id)->first(); // Menggunakan 'Store' dengan huruf kapital dan menambahkan '->first()' untuk mendapatkan satu hasil

        $store = $db->nama;
        $alamat = $db->alamat;


        $kartu_pasif = presensi::all();
        $marketing = marketing::all();
        $stores = store::all();
        $card = card::all();
        $klaim_presensi = reward::where('store_id', auth()->user()->store_id)->get();


        return view('staf.users.klaim_presensi', [
            'title' => 'Klaim Presensi',
            'store' => $store,
            'users' => $kartu_pasif,
            'marketings' => $marketing,
            'stores' => $stores,
            'cards' => $card,
            'klaim_presensis' => $klaim_presensi,
        ]);
    }
}
