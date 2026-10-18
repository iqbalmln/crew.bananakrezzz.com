<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorepresensiRequest;
use App\Jobs\SendWhatsappMessage;
use App\Http\Requests\UpdatepresensiRequest;
use App\Models\card;
use App\Models\card_level;
use App\Models\presensi;
use App\Models\reward;
use App\Models\setting;
use App\Models\store;
use App\Models\User;
use App\Support\WaTemplate;
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
        // belanja adalah nominal rupiah: tolak teks sejak di pintu masuk, supaya
        // tidak ada lagi "NABARU"/"B12" yang lolos ke database.
        $request->validate(['belanja' => 'nullable|numeric|min:0']);
        // Presensi manual (input absen kertas) ditandai lewat hidden input 'manual',
        // bukan lewat kosong/tidaknya tanggal seperti sebelumnya
        $manual = $request->manual == 1;

        if ($manual) {
            $request->validate([
                'nomor'   => 'required',
                'tgl'     => 'required|date',
                'belanja' => 'required|numeric|min:0',
                'image'   => 'required|image',
            ], [
                'nomor.required' => 'Crew belum dipilih dari hasil pencarian nomor KTP.',
                'tgl.required'   => 'Tanggal absen wajib diisi.',
                'belanja.required' => 'Total pembelian wajib diisi.',
                'image.required' => 'Bukti absen wajib diunggah.',
            ]);
        }

        $timestamp = time();
        $waktu = date('H:i', $timestamp);

        $destinationPath = 'image_presensi';
        $myimage = "";
        $belanja = null;

        if ($request->image != null) {
            // Nama file dibuat unik supaya upload dengan nama sama tidak saling menimpa
            $myimage = time() . '_' . uniqid() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path($destinationPath), $myimage);
        }
        if (isset($request->belanja)) {
            $today = Carbon::parse($request->tgl);
            $tgl = $today->format('d M Y');
            $belanja = $request->belanja;
        } else {
            $today = Carbon::now();
            $tgl = $today->format('d M Y');
        }



        // Cek apakah nomor ditemukan dalam tabel cards
        $cardCount = Card::where('nomor', $request->nomor)->count();

        if ($cardCount == 1) {

            // Presensi RFID dibatasi 1x per hari untuk kartu yang sama.
            // Presensi manual (input absen kertas) sengaja tidak dibatasi.
            if (! $manual) {
                $kartu = card::where('nomor', $request->nomor)->first();

                $presensiHariIni = presensi::where('card_id', $kartu->id)
                    ->where('tgl', $tgl)
                    ->count();

                if ($presensiHariIni >= 1) {
                    // Kartu sudah presensi hari ini — tetap tampilkan info crew & jumlah presensinya,
                    // supaya staf tidak perlu search ulang saat crew/biro tanya "sudah dapat berapa".
                    $min_presensi = Setting::value('min_presensi');
                    $cards = card::where('nomor', $request->nomor)->join('card_levels', 'cards.level', '=', 'card_levels.id')
                        ->select('cards.nomor', 'card_levels.nama')
                        ->get();

                    session()->flash('level', $cards);
                    session()->flash('pres', true);
                    session()->flash('nomor', 1);
                    session()->flash('presensis', presensi::where('card_id', $kartu->id)->latest()->get());
                    session()->flash('jumlah', presensi::where('card_id', $kartu->id)->count());
                    session()->flash('sudah_klaim', presensi::where('card_id', $kartu->id)->where('reward', 1)->count());
                    session()->flash('belum_klaim', presensi::where('card_id', $kartu->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
                    session()->flash('total_card', presensi::where('card_id', $kartu->id)->where('status', 2)->count());
                    session()->flash('total_crew', presensi::where('card_id', $kartu->id)->where('status', 1)->count());
                    session()->flash('crews', card::where('nomor', $request->nomor)->get());
                    session()->flash('stores', store::get());
                    session()->flash('presensi_reward', presensi::where('card_id', $kartu->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
                    session()->flash('presensis_klaim', presensi::where('card_id', $kartu->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->latest()->get());
                    session()->flash('rewards', reward::where('card_id', $kartu->id)->get());
                    session()->flash('min_presensi', $min_presensi);
                    session()->flash('marketing', User::where('id', $kartu->user_id)->get('nama'));
                    session()->flash('marketings', User::where('level', 'marketing')->get());

                    return back()->with('sudah_presensi', 'gagal');
                }
            }

            if ($request->presensi_double == 1) {

                $card_id = card::where('nomor', $request->nomor)->first();
                $store = store::where('id', Auth::user()->store_id)->value('id');
                presensi::create([
                    'card_id' =>  $card_id->id,
                    'waktu' => $waktu,
                    'tgl' => $tgl,
                    'status' => '',
                    'image' => $myimage,
                    'belanja' => $belanja,
                    'is_manual' => $manual,

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
                session()->flash('sudah_klaim', presensi::where('card_id', $card_id->id)->where('reward', 1)->count());
                session()->flash('belum_klaim', presensi::where('card_id', $card_id->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
                session()->flash('total_card', presensi::where('card_id', $card_id->id)->where('status', 2)->count());
                session()->flash('total_crew', presensi::where('card_id', $card_id->id)->where('status', 1)->count());
                session()->flash('crews', card::where('nomor', $request->nomor)->get());
                session()->flash('min_presensi', $min_presensi);
                session()->flash('stores', store::get());
                session()->flash('presensi_reward', presensi::where('card_id', $card_id->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
                session()->flash('presensis_klaim', presensi::where('card_id', $card_id->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->latest()->get());
                session()->flash('rewards', reward::where('card_id', $card_id->id)->get());

                session()->flash('marketing', User::where('id', $card_id->user_id)->get('nama'));
                session()->flash('marketings', User::where('level', 'marketing')->get());

                // Kirim notifikasi WhatsApp
                $phone = card::where('id', $card_id->id)->first()->hp;
                if ($phone) {
                    $storeName = store::where('id', Auth::user()->store_id)->value('nama');
                    SendWhatsappMessage::dispatch(
                        $this->formatNomor($phone),
                        WaTemplate::presensi($card_id->nama, $storeName, $tgl, $waktu)
                    );
                }

                return back()->with('berhasil_presensi', 'oke');
            } else {

                $card_id = card::where('nomor', $request->nomor)->first();
                $now = presensi::where('card_id', $card_id->id)->whereDate('created_at', $today)->first();

                // if ($now) {
                //     $min_presensi = Setting::value('min_presensi');

                //     $cards = card::where('nomor', $request->nomor)->join('card_levels', 'cards.level', '=', 'card_levels.id')
                //         ->select('card_levels.*', 'card_levels.nama')
                //         ->get();

                //     session()->flash('level', $cards);
                //     session()->flash('pres', true);
                //     session()->flash('nomor', 1);
                //     session()->flash('presensis', presensi::where('card_id', $card_id->id)->latest()->get());
                //     session()->flash('jumlah', presensi::where('card_id', $card_id->id)->count());
                //     session()->flash('total_card', presensi::where('card_id', $card_id->id)->where('status', 2)->count());
                //     session()->flash('total_crew', presensi::where('card_id', $card_id->id)->where('status', 1)->count());
                //     session()->flash('presensi_reward', presensi::where('card_id', $card_id->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
                //     session()->flash('crews', card::where('nomor', $request->nomor)->get());
                //     session()->flash('min_presensi', $min_presensi);
                //     session()->flash('presensis_klaim', presensi::where('card_id', $card_id->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->latest()->get());
                //     session()->flash('rewards', reward::where('card_id', $card_id->id)->get());
                //     session()->flash('marketing', User::where('id', $card_id->user_id)->get('nama'));
                //     session()->flash('marketings', User::where('level', 'marketing')->get());
                //     session()->flash('stores', store::get());
                //     return back()->with('sudah_presensi', 'gagal');
                // } else {

                $card_id = Card::where('nomor', $request->nomor)->first();
                $store = store::where('id', Auth::user()->store_id)->value('id');
                // Presensi RFID langsung disetujui. Presensi manual (input absen kertas oleh staf)
                // sengaja menunggu approval Admin/Master, bukti fotonya jadi dasar mereka approve.
                if (! $manual) {
                    presensi::create([
                        'card_id' =>  $card_id->id,
                        'store_id' =>  $store,
                        'waktu' => $waktu,
                        'tgl' => $tgl,
                        'status' => '2',
                        'status_approve' => '1',
                        'image' => $myimage,
                        'belanja' => $belanja,
                        'is_manual' => false,
                    ]);
                } else {
                    presensi::create([
                        'card_id' =>  $card_id->id,
                        'store_id' =>  $store,
                        'waktu' => $waktu,
                        'tgl' => $tgl,
                        'status' => '',
                        'status_approve' => '0',
                        'image' => $myimage,
                        'belanja' => $belanja,
                        'is_manual' => true,
                    ]);
                }
                $min_presensi = Setting::value('min_presensi');
                $cards = card::where('nomor', $request->nomor)->join('card_levels', 'cards.level', '=', 'card_levels.id')
                    ->select('cards.nomor', 'card_levels.nama')
                    ->get();
                session()->flash('level', $cards);
                session()->flash('pres', true);
                session()->flash('nomor', 1);


                session()->flash('presensis', presensi::where('card_id', $card_id->id)->latest()->get());
                session()->flash('jumlah', presensi::where('card_id', $card_id->id)->count());
                session()->flash('sudah_klaim', presensi::where('card_id', $card_id->id)->where('reward', 1)->count());
                session()->flash('belum_klaim', presensi::where('card_id', $card_id->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
                session()->flash('total_card', presensi::where('card_id', $card_id->id)->where('status', 2)->count());
                session()->flash('total_crew', presensi::where('card_id', $card_id->id)->where('status', 1)->count());
                session()->flash('crews', card::where('nomor', $request->nomor)->get());
                session()->flash('stores', store::get());
                session()->flash('presensi_reward', presensi::where('card_id', $card_id->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
                session()->flash('presensis_klaim', presensi::where('card_id', $card_id->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->latest()->get());
                session()->flash('rewards', reward::where('card_id', $card_id->id)->get());
                session()->flash('min_presensi', $min_presensi);

                session()->flash('marketing', User::where('id', $card_id->user_id)->get('nama'));
                session()->flash('marketings', User::where('level', 'marketing')->get());

                // Kirim notifikasi WhatsApp
                $phone = card::where('id', $card_id->id)->first()->hp;
                if ($phone) {
                    $storeName = store::where('id', Auth::user()->store_id)->value('nama');
                    SendWhatsappMessage::dispatch(
                        $this->formatNomor($phone),
                        WaTemplate::presensi($card_id->nama, $storeName, $tgl, $waktu)
                    );
                }

                return back()->with('berhasil_presensi', 'oke');
                // }
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
            session()->flash('presensi_reward', presensi::where('card_id', $card_id->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
            session()->flash('presensis_klaim', presensi::where('card_id', $card_id->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->latest()->get());
            session()->flash('rewards', reward::where('card_id', $card_id->id)->get());
            session()->flash('jumlah', presensi::all());
            session()->flash('sudah_klaim', presensi::where('card_id', $card_id->id)->where('reward', 1)->count());
            session()->flash('belum_klaim', presensi::where('card_id', $card_id->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());

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
        // belanja adalah nominal rupiah: tolak teks sejak di pintu masuk, supaya
        // tidak ada lagi "NABARU"/"B12" yang lolos ke database.
        $request->validate(['belanja' => 'nullable|numeric|min:0']);


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
                        'status_approve' => 1,
                        'rombongan' =>  $request->rombongan,
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
                        'status_approve' => 1,
                        'rombongan' =>  $request->rombongan,
                    ]
                );
        }


        $cards = Card::where('cards.id', $request->card_id)
            ->join('card_levels', 'cards.level', '=', 'card_levels.id')
            ->select('card_levels.*', 'card_levels.nama')
            ->get();

        $phone = card::where('id', $request->card_id)->first()->hp;
        SendWhatsappMessage::dispatch(
            $this->formatNomor($phone),
            WaTemplate::kedatangan($request->rombongan, date("Y-m-d"))
        );


        session()->flash('level', $cards);
        session()->flash('pres', true);
        session()->flash('nomor', 1);
        session()->flash('presensis', presensi::where('card_id', $request->card_id)->latest()->get());
        session()->flash('jumlah', presensi::where('card_id', $request->card_id)->count());
        session()->flash('sudah_klaim', presensi::where('card_id', $request->card_id)->where('reward', 1)->count());
        session()->flash('belum_klaim', presensi::where('card_id', $request->card_id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
        session()->flash('total_card', presensi::where('card_id',  $request->card_id)->where('status', 2)->count());
        session()->flash('total_crew', presensi::where('card_id',  $request->card_id)->where('status', 1)->count());
        session()->flash('crews', card::where('id', $request->card_id)->get());
        session()->flash('min_presensi', $min_presensi);
        session()->flash('presensi_reward', presensi::where('card_id', $request->card_id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
        session()->flash('presensis_klaim', presensi::where('card_id', $request->card_id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->latest()->get());
        session()->flash('rewards', reward::where('card_id',  $request->card_id)->get());
        session()->flash('stores', store::get());
        session()->flash('marketing', User::where('id', $request->user_id)->get('nama'));
        session()->flash('marketings', User::where('level', 'marketing')->get());
        return back()->with('berhasil_update_crew', 'oke');
    }

    public function formatNomor($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone); // hapus karakter selain angka
        if (substr($phone, 0, 2) === '62') {
            return $phone;
        } elseif (substr($phone, 0, 1) === '0') {
            return '62' . substr($phone, 1);
        } else {
            return $phone; // jika tidak 0 atau 62 di awal, biarkan saja
        }
    }

    public function klaim_reward(Request $request)
    {
        // belanja adalah nominal rupiah: tolak teks sejak di pintu masuk, supaya
        // tidak ada lagi "NABARU"/"B12" yang lolos ke database.
        $request->validate(['belanja' => 'nullable|numeric|min:0']);

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
        $total_presensi =  presensi::where('card_id', $request->card_id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count();
        $lokasi = store::where('id', Auth::user()->store_id)->value('nama');
        $store = store::where('id', Auth::user()->store_id)->value('id');
        reward::create([
            'card_id' => $request->card_id,
            'store_id' => $store,
            'tgl' => $tgl,
            'presensi' => $total_presensi,
            'lokasi' => $lokasi

        ]);

        presensi::where('card_id', $request->card_id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->update(['reward' => true]);

        $phone = card::where('id', $request->card_id)->first()->hp;
        SendWhatsappMessage::dispatch($this->formatNomor($phone), WaTemplate::klaimReward());


        $cards = Card::where('cards.id', $request->card_id)
            ->join('card_levels', 'cards.level', '=', 'card_levels.id')
            ->select('card_levels.*', 'card_levels.nama')
            ->get();


        session()->flash('level', $cards);
        session()->flash('pres', true);
        session()->flash('nomor', 1);
        session()->flash('presensis', presensi::where('card_id', $request->card_id)->latest()->get());
        session()->flash('jumlah', presensi::where('card_id', $request->card_id)->count());
        session()->flash('sudah_klaim', presensi::where('card_id', $request->card_id)->where('reward', 1)->count());
        session()->flash('belum_klaim', presensi::where('card_id', $request->card_id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
        session()->flash('total_card', presensi::where('card_id',  $request->card_id)->where('status', 2)->count());
        session()->flash('total_crew', presensi::where('card_id',  $request->card_id)->where('status', 1)->count());
        session()->flash('crews', card::where('id', $request->card_id)->get());
        session()->flash('min_presensi', $min_presensi);
        session()->flash('stores', store::get());
        session()->flash('presensi_reward', presensi::where('card_id', $request->card_id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
        session()->flash('presensis_klaim', presensi::where('card_id', $request->card_id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->latest()->get());
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
            session()->flash('sudah_klaim', presensi::where('card_id', $card->id)->where('reward', 1)->count());
            session()->flash('belum_klaim', presensi::where('card_id', $card->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
            session()->flash('total_card', Presensi::where('card_id', $card->id)->where('status', 2)->count());
            session()->flash('total_crew', Presensi::where('card_id', $card->id)->where('status', 1)->count());
            session()->flash('crews', Card::where('id', $card->id)->get());
            session()->flash('min_presensi', $min_presensi);
            session()->flash('rewards', reward::where('card_id', $card->id)->get());
            session()->flash('stores', store::get());

            session()->flash('presensi_reward', presensi::where('card_id', $card->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
            session()->flash('presensis_klaim', presensi::where('card_id', $card->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->latest()->get());

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
        // belanja adalah nominal rupiah: tolak teks sejak di pintu masuk, supaya
        // tidak ada lagi "NABARU"/"B12" yang lolos ke database.
        $request->validate(['belanja' => 'nullable|numeric|min:0']);

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

    public function approve_presence($id)
    {
        presensi::where('id', $id)
            ->update(
                [
                    'status_approve' => '1',
                ]
            );

        return back()->with('berhasil_update_status', 'oke');
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

    function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format((float) ($angka ?? 0), 0, ',', '.');
        return $hasil_rupiah;
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
