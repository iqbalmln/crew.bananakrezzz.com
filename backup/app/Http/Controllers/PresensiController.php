<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorepresensiRequest;
use App\Http\Requests\UpdatepresensiRequest;
use App\Models\card;
use App\Models\card_level;
use App\Models\presensi;
use App\Models\reward;
use App\Models\setting;
use App\Models\store;
use App\Models\User;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Monolog\Level;

class PresensiController extends Controller
{

    public function index()
    {
        $db = Store::where('id', auth()->user()->store_id)->first(); // Menggunakan 'Store' dengan huruf kapital dan menambahkan '->first()' untuk mendapatkan satu hasil

        $store = $db->nama;
        $alamat = $db->alamat;

        $hariSaatIni = Carbon::now()->startOfDay(); // Start of the current day
        $hariSaatIniSelesai = Carbon::now()->endOfDay(); // End of the current day

        $presensiTertinggi = presensi::where('store_id', auth()->user()->store_id)->whereBetween('created_at', [$hariSaatIni, $hariSaatIniSelesai])->max('kode_hari');
        $presensi_hari = presensi::where('store_id', auth()->user()->store_id)
            ->whereBetween('created_at', [$hariSaatIni, $hariSaatIniSelesai])
            ->get();


        return view('home.home', [
            'title' => 'Presensi Crew',
            'store' => $store,
            'alamat' => $alamat,
            'kode_hari' => $presensiTertinggi,
            'presensi_hari' => $presensi_hari,
        ]);
    }


    public function add_presensi(Request $request)
    {
        $timestamp = time();
        $waktu = date('H:i', $timestamp);

        $today = Carbon::now();
        $tgl = $today->format('d M Y');



        // Cek apakah nomor ditemukan dalam tabel cards
        $cardCount = Card::where('nomor', $request->nomor)->count();

        if ($cardCount == 1) {

            if ($request->presensi_double == 1) {

                $card_id = card::where('nomor', $request->nomor)->first();
                $store = store::where('id', Auth::user()->store_id)->value('id');
                presensi::create([
                    'card_id' =>  $card_id->id,
                    'nomor' =>  $request->nomor,
                    'nomor' =>  $request->nomor,
                    'waktu' => $waktu,
                    'tgl' => $tgl,
                    'status' => '',

                ]);
                $min_presensi = Setting::value('min_presensi');
                $cards = card::where('nomor', $request->nomor)->join('card_levels', 'cards.level', '=', 'card_levels.id')
                    ->select('cards.nomor', 'card_levels.nama')
                    ->get();
                session()->flash('level', $cards);
                session()->flash('pres', true);
                session()->flash('nomor', 1);


                session()->flash('presensis', presensi::where('card_id', $card_id->id)->latest()->get());
                session()->flash('jumlah', presensi::where('card_id', $card_id->id)->count());
                session()->flash('total_card', presensi::where('card_id', $card_id->id)->where('status', 2)->count());
                session()->flash('total_crew', presensi::where('card_id', $card_id->id)->where('status', 1)->count());
                session()->flash('crews', card::where('nomor', $request->nomor)->get());
                session()->flash('min_presensi', $min_presensi);
                session()->flash('stores', store::get());
                session()->flash('presensi_reward', presensi::where('card_id', $card_id->id)->where('status', 2)->where('reward', 0)->count());
                session()->flash('rewards', reward::where('card_id', $card_id->id)->get());

                session()->flash('marketing', User::where('id', $card_id->user_id)->get('nama'));
                session()->flash('marketings', User::where('level', 'marketing')->get());

                return back()->with('berhasil_presensi', 'oke');
            } else {

                $card_id = card::where('nomor', $request->nomor)->first();
                $now = presensi::where('card_id', $card_id->id)->whereDate('created_at', $today)->first();

                if ($now) {
                    $min_presensi = Setting::value('min_presensi');

                    $cards = card::where('nomor', $request->nomor)->join('card_levels', 'cards.level', '=', 'card_levels.id')
                        ->select('card_levels.*', 'card_levels.nama')
                        ->get();

                    session()->flash('level', $cards);
                    session()->flash('pres', true);
                    session()->flash('nomor', 1);
                    session()->flash('presensis', presensi::where('card_id', $card_id->id)->latest()->get());
                    session()->flash('jumlah', presensi::where('card_id', $card_id->id)->count());
                    session()->flash('total_card', presensi::where('card_id', $card_id->id)->where('status', 2)->count());
                    session()->flash('total_crew', presensi::where('card_id', $card_id->id)->where('status', 1)->count());
                    session()->flash('presensi_reward', presensi::where('card_id', $card_id->id)->where('status', 2)->where('reward', 0)->count());
                    session()->flash('crews', card::where('nomor', $request->nomor)->get());
                    session()->flash('min_presensi', $min_presensi);
                    session()->flash('presensis_klaim', presensi::where('card_id', $card_id->id)->where('status', 2)->where('reward', 0)->latest()->get());
                    session()->flash('rewards', reward::where('card_id', $card_id->id)->get());
                    session()->flash('marketing', User::where('id', $card_id->user_id)->get('nama'));
                    session()->flash('marketings', User::where('level', 'marketing')->get());
                    session()->flash('stores', store::get());
                    return back()->with('sudah_presensi', 'gagal');
                } else {

                    $card_id = Card::where('nomor', $request->nomor)->first();
                    $store = store::where('id', Auth::user()->store_id)->value('id');
                    presensi::create([
                        'card_id' =>  $card_id->id,
                        'store_id' =>  $store,
                        'nomor' =>  $request->nomor,
                        'nomor' =>  $request->nomor,
                        'waktu' => $waktu,
                        'tgl' => $tgl,
                        'status' => '',
                    ]);
                    $min_presensi = Setting::value('min_presensi');
                    $cards = card::where('nomor', $request->nomor)->join('card_levels', 'cards.level', '=', 'card_levels.id')
                        ->select('cards.nomor', 'card_levels.nama')
                        ->get();
                    session()->flash('level', $cards);
                    session()->flash('pres', true);
                    session()->flash('nomor', 1);


                    session()->flash('presensis', presensi::where('card_id', $card_id->id)->latest()->get());
                    session()->flash('jumlah', presensi::where('card_id', $card_id->id)->count());
                    session()->flash('total_card', presensi::where('card_id', $card_id->id)->where('status', 2)->count());
                    session()->flash('total_crew', presensi::where('card_id', $card_id->id)->where('status', 1)->count());
                    session()->flash('crews', card::where('nomor', $request->nomor)->get());
                    session()->flash('stores', store::get());
                    session()->flash('presensi_reward', presensi::where('card_id', $request->card_id)->where('status', 2)->where('reward', 0)->count());
                    session()->flash('rewards', reward::where('card_id', $card_id->id)->get());
                    session()->flash('min_presensi', $min_presensi);

                    session()->flash('marketing', User::where('id', $card_id->user_id)->get('nama'));
                    session()->flash('marketings', User::where('level', 'marketing')->get());

                    return back()->with('berhasil_presensi', 'oke');
                }
            }
        } elseif ($cardCount > 1) {
            // Jika lebih dari satu data ditemukan, tampilkan pesan "data lebih dari satu"
            session()->forget('pres');
            $card_id = card::where('nomor', $request->nomor)->get('id');
            $min_presensi = Setting::value('min_presensi');
            $cards = card::where('nomor', $request->nomor)->join('card_levels', 'cards.level', '=', 'card_levels.id')
                ->select('cards.nomor', 'card_levels.nama')
                ->get();
            session()->flash('level', $cards);
            session()->flash('info', true);
            session()->flash('nomor', 1);
            session()->flash('presensis', presensi::where('card_id', $card_id)->latest()->get());
            session()->flash('marketing', User::where('id', $card_id->level)->get('nama'));
            session()->flash('marketings', User::where('level', 'marketing')->get());
            session()->flash('presensi_reward', presensi::where('card_id', $card_id->id)->where('status', 2)->where('reward', 0)->count());
            session()->flash('rewards', reward::where('card_id', $card_id->id)->get());
            session()->flash('jumlah', presensi::all());

            session()->flash('min_presensi', $min_presensi);
            session()->flash('stores', store::get());
            session()->flash('crews', card::where('nomor', $request->nomor)->get());

            return back();
        } else {
            // Jika tidak ada data yang ditemukan, tampilkan pesan "no"
            session()->forget('pres');

            return back()->with('gagal', 'gagal');
        }
    }




    public function fee()
    {
        $today = Carbon::today();

        return view('fee.home', [

            'presensis' => Presensi::whereDate('created_at', $today)->latest()->get(),
            'cards' => card::all(),
            'users' => user::all(),
            'info' => 'Data hari ini diurutkan dari yang terbaru',
            'levels' => card_level::all(),

        ]);
    }


    public function fee_filter(Request $request)
    {
        if ($request->filter == 'minggu') {

            $startOfWeek = Carbon::today()->startOfWeek();
            $endOfWeek = Carbon::today()->endOfWeek();

            return view('fee.home', [
                'presensis' => Presensi::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                    ->latest()
                    ->get(),
                'cards' => Card::all(),
                'users' => User::all(),
                'info' => 'Data minggu ini diurutkan dari yang terbaru',
                'levels' => Card_level::all(),
            ]);
        } elseif ($request->filter == 'bulan') {
            $startOfMonth = Carbon::today()->startOfMonth();
            $endOfMonth = Carbon::today()->endOfMonth();

            return view('fee.home', [
                'presensis' => Presensi::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->latest()
                    ->get(),
                'cards' => Card::all(),
                'users' => User::all(),
                'info' => 'Data bulan ini diurutkan dari yang terbaru',
                'levels' => Card_level::all(),
            ]);
        } elseif ($request->filter == 'search') {
            $startOfMonth = Carbon::today()->startOfMonth();
            $endOfMonth = Carbon::today()->endOfMonth();
            $card = Card::where('nomor', $request->nomor)->first();
            if ($card == '') {
                return view('fee.home')->with([
                    'presensis' => [],
                    'cards' => Card::all(),
                    'users' => User::all(),
                    'info' => 'Card ID Tidak Ditemukan',
                    'levels' => Card_level::all(),
                ]);
            } else {
                $presensis = Presensi::where('card_id', $card->id)
                    ->latest()
                    ->get();

                return view('fee.home')->with([
                    'presensis' => $presensis,
                    'cards' => Card::all(),
                    'users' => User::all(),
                    'info' => 'Menampilkan Data ' . $request->nomor,
                    'levels' => Card_level::all(),
                ]);
            }
        }
    }



    public function fee_update(Request $request)
    {
        echo $request->presensi_id;


        presensi::where('id', $request->presensi_id)
            ->update(
                [
                    'fee' =>  $request->fee,
                ]
            );

        return back()->with('berhasil', 'oke');
    }




    public function add_belanja(Request $request)
    {


        $hariSaatIni = Carbon::now()->startOfDay(); // Start of the current day
        $hariSaatIniSelesai = Carbon::now()->endOfDay(); // End of the current day

        $db = Setting::value('belanja');
        $min_presensi = Setting::value('min_presensi');
        $belanja = $request->belanja;
        if ($db >= $belanja) {
            $status = 1;
        }
        if ($db < $belanja) {
            $status = 2;
        }


        if ($request->sinkron == 1) {

            presensi::where('store_id', auth()->user()->store_id)
                ->where('kode_hari', $request->kode_hari)
                ->whereBetween('created_at', [$hariSaatIni, $hariSaatIniSelesai])
                ->update(
                    [
                        'kode_hari' => $request->kode_hari,
                        'belanja' => $belanja,
                        'po' =>  $request->po,
                        'biro' =>  $request->biro,
                        'bus' =>  $request->bus,
                        'ket' =>  $request->ket,
                        'status' =>  $status,
                    ]
                );
        } else {

            presensi::where('id', $request->presensi_id)
                ->update(
                    [
                        'kode_hari' => $request->kode_hari,
                        'belanja' => $belanja,
                        'po' =>  $request->po,
                        'biro' =>  $request->biro,
                        'bus' =>  $request->bus,
                        'ket' =>  $request->ket,
                        'status' =>  $status,
                    ]
                );
        }


        $cards = Card::where('cards.id', $request->card_id)
            ->join('card_levels', 'cards.level', '=', 'card_levels.id')
            ->select('card_levels.*', 'card_levels.nama')
            ->get();


        session()->flash('level', $cards);
        session()->flash('pres', true);
        session()->flash('nomor', 1);
        session()->flash('presensis', presensi::where('card_id', $request->card_id)->latest()->get());
        session()->flash('jumlah', presensi::where('card_id', $request->card_id)->count());
        session()->flash('total_card', presensi::where('card_id',  $request->card_id)->where('status', 2)->count());
        session()->flash('total_crew', presensi::where('card_id',  $request->card_id)->where('status', 1)->count());
        session()->flash('crews', card::where('id', $request->card_id)->get());
        session()->flash('min_presensi', $min_presensi);
        session()->flash('presensi_reward', presensi::where('card_id', $request->card_id)->where('status', 2)->where('reward', 0)->count());
        session()->flash('rewards', reward::where('card_id',  $request->card_id)->get());
        session()->flash('stores', store::get());
        session()->flash('marketing', User::where('id', $request->user_id)->get('nama'));
        session()->flash('marketings', User::where('level', 'marketing')->get());
        return back()->with('berhasil_update_crew', 'oke');
    }


    public function klaim_reward(Request $request)
    {

        $db = Setting::value('belanja');
        $min_presensi = Setting::value('min_presensi');
        $belanja = $request->belanja;
        if ($db >= $belanja) {
            $status = 1;
        }
        if ($db < $belanja) {
            $status = 2;
        }

        $timestamp = time();
        $waktu = date('H:i', $timestamp);

        $today = Carbon::now();
        $tgl = $today->format('d M Y');
        $total_presensi =  presensi::where('card_id', $request->card_id)->where('status', 2)->where('reward', 0)->count();
        $lokasi = store::where('id', Auth::user()->store_id)->value('nama');
        $store = store::where('id', Auth::user()->store_id)->value('id');

        reward::create([
            'card_id' => $request->card_id,
            'store_id' => $store,
            'tgl' => $tgl,
            'presensi' => $total_presensi,
            'lokasi' => $lokasi

        ]);
        
        presensi::where('card_id', $request->card_id)->where('status', 2)->where('reward', 0)->update(['reward' => true]);
    
    
       

        $cards = Card::where('cards.id', $request->card_id)
            ->join('card_levels', 'cards.level', '=', 'card_levels.id')
            ->select('card_levels.*', 'card_levels.nama')
            ->get();


        session()->flash('level', $cards);
        session()->flash('pres', true);
        session()->flash('nomor', 1);
        session()->flash('presensis', presensi::where('card_id', $request->card_id)->latest()->get());
        session()->flash('jumlah', presensi::where('card_id', $request->card_id)->count());
        session()->flash('total_card', presensi::where('card_id',  $request->card_id)->where('status', 2)->count());
        session()->flash('total_crew', presensi::where('card_id',  $request->card_id)->where('status', 1)->count());
        session()->flash('crews', card::where('id', $request->card_id)->get());
        session()->flash('min_presensi', $min_presensi);
        session()->flash('stores', store::get());
        session()->flash('presensi_reward', presensi::where('card_id', $request->card_id)->where('status', 2)->where('reward', 0)->count());
        session()->flash('rewards', reward::where('card_id', $request->card_id)->get());

        session()->flash('marketing', User::where('id', $request->user_id)->get('nama'));
        session()->flash('marketings', User::where('level', 'marketing')->get());
        return back()->with('berhasil_update_crew', 'oke');
    }
    public function detail_card(Request $request)
    {
        $db = Store::where('id', auth()->user()->store_id)->first(); // Menggunakan 'Store' dengan huruf kapital dan menambahkan '->first()' untuk mendapatkan satu hasil

        $store = $db->nama;
        $alamat = $db->alamat;

        $min_presensi = Setting::value('min_presensi');

        $card = Card::where('nomor', $request->nomor)->first(); // Menggunakan first() untuk mendapatkan satu hasil

        $hariSaatIni = Carbon::now()->startOfDay(); // Start of the current day
        $hariSaatIniSelesai = Carbon::now()->endOfDay(); // End of the current day

        $presensiTertinggi = presensi::where('store_id', auth()->user()->store_id)->whereBetween('created_at', [$hariSaatIni, $hariSaatIniSelesai])->max('kode_hari');
        $presensi_hari = presensi::where('store_id', auth()->user()->store_id)
            ->whereBetween('created_at', [$hariSaatIni, $hariSaatIniSelesai])
            ->get();

        if ($card) {
            session()->flash('pres', true);
            session()->flash('search', false);
            session()->flash('nomor', 1);
            session()->flash('presensis', Presensi::where('card_id', $card->id)->latest()->get());
            session()->flash('jumlah', Presensi::where('card_id', $card->id)->count());
            session()->flash('total_card', Presensi::where('card_id', $card->id)->where('status', 2)->count());
            session()->flash('total_crew', Presensi::where('card_id', $card->id)->where('status', 1)->count());
            session()->flash('crews', Card::where('id', $card->id)->get());
            session()->flash('min_presensi', $min_presensi);
            session()->flash('rewards', reward::where('card_id', $card->id)->get());
            session()->flash('stores', store::get());
            session()->flash('presensis_klaim', presensi::where('card_id', $card->id)->where('status', 2)->where('reward', 0)->latest()->get());

            session()->flash('presensi_reward', presensi::where('card_id', $card->id)->where('status', 2)->where('reward', 0)->count());

            // Jika diperlukan, kamu bisa menambahkan informasi lain ke dalam session di sini

            return view('home.home', [
                'title' => 'Cari Kartu',
                'store' => $store,
                'alamat' => $alamat,
                'cards' => '',
                'presensis' => '',
                'kode_hari' => $presensiTertinggi,
                'presensi_hari' => $presensi_hari,
            ]);
        } else {
            return back()->withErrors(['message' => 'Card tidak ditemukan']); // Memberikan pesan error jika card tidak ditemukan
        }
    }

    public function update_belanja(Request $request)
    {

        $db = Setting::value('belanja');
        $min_presensi = Setting::value('min_presensi');
        $belanja = $request->belanja;
        if ($db >= $belanja) {
            $status = 1;
        }
        if ($db < $belanja) {
            $status = 2;
        }


        presensi::where('id', $request->presensi_id)
            ->update(
                [
                    'belanja' => $belanja,
                    'po' =>  $request->po,
                    'marketing_id' =>  $request->marketing,
                    'bus' =>  $request->bus,
                    'ket' =>  $request->ket,
                    'status' =>  $status,
                ]
            );

        return back()->with('berhasil_update_crew', 'oke');
    }


public function cari_cardm(Request $request)
{
    $ktp = $request->ktp;

    // Cari data crew yang nomornya mengandung KTP yang diinputkan
   $data = Card::where('nik', 'like', "%$ktp%")->get();
\Log::info('Query executed: ' . Card::where('nik', 'like', "%$ktp%")->toSql());


    if ($data->count() > 0) {
        return response()->json([
            'success' => true,
            'data' => $data // Kirimkan array data crew
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }
}



    // public function add_presensi_id(Request $request)
    // {
    //     $timestamp = time();
    //     $waktu = date('H:i', $timestamp);

    //     $today = Carbon::now();
    //     $tgl = $today->format('d M Y');



    //     // Cek apakah nomor ditemukan dalam tabel cards

    //     if ($request->presensi_double == 1) {
    //         echo 'doble';
    //         // $card_id = Card::where('nomor', $request->nomor)->first();
    //         // presensi::create([
    //         //     'card_id' =>  $card_id->id,
    //         //     'nomor' =>  $request->nomor,
    //         //     'nomor' =>  $request->nomor,
    //         //     'waktu' => $waktu,
    //         //     'tgl' => $tgl,
    //         //     'status' => 'Presensi',
    //         // ]);
    //         // session()->flash('pres', true);
    //         // session()->flash('nomor', 1);
    //         // session()->flash('presensis', presensi::where('nomor', $request->nomor)->get());
    //         // session()->flash('jumlah', presensi::where('nomor', $request->nomor)->count());
    //         // session()->flash('crews', card::where('nomor', $request->nomor)->get());



    //         // return back()->with('berhasil_presensi', 'oke');
    //     } else {
    //         echo 'none';
    //         // $now = presensi::where('nomor', $request->nomor)->whereDate('created_at', $today)->first();
    //         // if ($now) {

    //         //     session()->flash('pres', true);
    //         //     session()->flash('nomor', 1);
    //         //     session()->flash('presensis', presensi::where('nomor', $request->nomor)->get());
    //         //     session()->flash('jumlah', presensi::where('nomor', $request->nomor)->count());
    //         //     session()->flash('crews', card::where('nomor', $request->nomor)->get());
    //         //     return back()->with('sudah_presensi', 'gagal');
    //         // } else {

    //         //     $card_id = Card::where('nomor', $request->nomor)->first();
    //         // presensi::create([
    //         //     'card_id' =>  $card_id->id,
    //         //     'nomor' =>  $request->nomor,
    //         //     'nomor' =>  $request->nomor,
    //         //     'waktu' => $waktu,
    //         //     'tgl' => $tgl,
    //         //     'status' => 'Presensi',
    //         // ]);
    //         //     session()->flash('pres', true);
    //         //     session()->flash('nomor', 1);
    //         //     session()->flash('presensis', presensi::where('nomor', $request->nomor)->get());
    //         //     session()->flash('jumlah', presensi::where('nomor', $request->nomor)->count());
    //         //     session()->flash('crews', card::where('nomor', $request->nomor)->get());



    //         //     return back();
    //         // }
    //     }
    // }
}
