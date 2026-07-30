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

        $destinationPath = 'image_presensi';
        $myimage = "";
        $belanja = null;

        if ($request->image != null) {
            $myimage = $request->image->getClientOriginalName();
            $request->image->move(public_path($destinationPath), $myimage);
        }
        if(isset($request->belanja)){
            $today = Carbon::parse($request->tgl);
            $tgl = $today->format('d M Y');
            $belanja = $request->belanja;
        }else{
            $today = Carbon::now();
            $tgl = $today->format('d M Y');
        }



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
                    'image' => $myimage,
                    'belanja' => $belanja

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
                session()->flash('sudah_klaim', presensi::where('card_id', $card_id->id)->where('reward',1)->count());
                session()->flash('belum_klaim', presensi::where('card_id', $card_id->id)->where('reward',0)->where('status',2)->where('status_approve',1)->count());
                session()->flash('total_card', presensi::where('card_id', $card_id->id)->where('status', 2)->count());
                session()->flash('total_crew', presensi::where('card_id', $card_id->id)->where('status', 1)->count());
                session()->flash('crews', card::where('nomor', $request->nomor)->get());
                session()->flash('min_presensi', $min_presensi);
                session()->flash('stores', store::get());
                session()->flash('presensi_reward', presensi::where('card_id', $card_id->id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
                session()->flash('rewards', reward::where('card_id', $card_id->id)->get());

                session()->flash('marketing', User::where('id', $card_id->user_id)->get('nama'));
                session()->flash('marketings', User::where('level', 'marketing')->get());

                // Kirim notifikasi WhatsApp
                $phone = card::where('id', $card_id->id)->first()->hp;
                if ($phone) {
                    $phone = $this->formatNomor($phone);
                    $storeName = store::where('id', Auth::user()->store_id)->value('nama');

                    $api_key_wa = "u2a53a9beb36e4f5.7dc9be52f701442cafbf96cc899838f8";
                    $url_wa = 'https://wa5901.oneapi.my.id/api/v1/messages';

                    $client = new MessageBuilder([
                        'api_url' => $url_wa,
                        'api_key' => $api_key_wa,
                    ]);

                    $text = $client->to($phone)
                        ->content("Presensi panjenengan sampun kasil! &#13;&#13;Wonten ing $storeName &#13;Tanggal : $tgl &#13;Wekdal : $waktu &#13;&#13;Matur Suwun sampun pinarak Kampoeng Banana Krezzz🙏🏻☺️")
                        ->save();

                    $messages = [$text];
                    $client->send($messages);
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
                //     session()->flash('presensi_reward', presensi::where('card_id', $card_id->id)->where('status', 2)->where('reward', 0)->count());
                //     session()->flash('crews', card::where('nomor', $request->nomor)->get());
                //     session()->flash('min_presensi', $min_presensi);
                //     session()->flash('presensis_klaim', presensi::where('card_id', $card_id->id)->where('status', 2)->where('reward', 0)->latest()->get());
                //     session()->flash('rewards', reward::where('card_id', $card_id->id)->get());
                //     session()->flash('marketing', User::where('id', $card_id->user_id)->get('nama'));
                //     session()->flash('marketings', User::where('level', 'marketing')->get());
                //     session()->flash('stores', store::get());
                //     return back()->with('sudah_presensi', 'gagal');
                // } else {

                    $card_id = Card::where('nomor', $request->nomor)->first();
                    $store = store::where('id', Auth::user()->store_id)->value('id');
                    if ($request->tgl == null) {
                        presensi::create([
                            'card_id' =>  $card_id->id,
                            'store_id' =>  $store,
                            'nomor' =>  $request->nomor,
                            'nomor' =>  $request->nomor,
                            'waktu' => $waktu,
                            'tgl' => $tgl,
                            'status' => '2',
                            'status_approve' => '1',
                            'image' => $myimage,
                            'belanja' => $belanja
                        ]);
                    }else{
                        presensi::create([
                            'card_id' =>  $card_id->id,
                            'store_id' =>  $store,
                            'nomor' =>  $request->nomor,
                            'nomor' =>  $request->nomor,
                            'waktu' => $waktu,
                            'tgl' => $tgl,
                            'status' => '',
                            'image' => $myimage,
                            'belanja' => $belanja
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
                    session()->flash('sudah_klaim', presensi::where('card_id', $card_id->id)->where('reward',1)->count());
                    session()->flash('belum_klaim', presensi::where('card_id', $card_id->id)->where('reward',0)->where('status',2)->where('status_approve',1)->count());
                    session()->flash('total_card', presensi::where('card_id', $card_id->id)->where('status', 2)->count());
                    session()->flash('total_crew', presensi::where('card_id', $card_id->id)->where('status', 1)->count());
                    session()->flash('crews', card::where('nomor', $request->nomor)->get());
                    session()->flash('stores', store::get());
                    session()->flash('presensi_reward', presensi::where('card_id', $request->card_id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
                    session()->flash('rewards', reward::where('card_id', $card_id->id)->get());
                    session()->flash('min_presensi', $min_presensi);

                    session()->flash('marketing', User::where('id', $card_id->user_id)->get('nama'));
                    session()->flash('marketings', User::where('level', 'marketing')->get());

                    // Kirim notifikasi WhatsApp
                    $phone = card::where('id', $card_id->id)->first()->hp;
                    if ($phone) {
                        $phone = $this->formatNomor($phone);
                        $storeName = store::where('id', Auth::user()->store_id)->value('nama');

                        $api_key_wa = "u2a53a9beb36e4f5.7dc9be52f701442cafbf96cc899838f8";
                        $url_wa = 'https://wa5901.oneapi.my.id/api/v1/messages';

                        $client = new MessageBuilder([
                            'api_url' => $url_wa,
                            'api_key' => $api_key_wa,
                        ]);

                        $text = $client->to($phone)
                            ->content("Presensi panjenengan sampun kasil! &#13;&#13;Wonten ing $storeName &#13;Tanggal : $tgl &#13;Wekdal : $waktu &#13;&#13;Matur Suwun sampun pinarak Kampoeng Banana Krezzz🙏🏻☺️")
                            ->save();

                        $messages = [$text];
                        $client->send($messages);
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
            session()->flash('rewards', reward::where('card_id', $card_id->id)->get());
            session()->flash('jumlah', presensi::all());
            session()->flash('sudah_klaim', presensi::where('card_id', $card_id->id)->where('reward',1)->count());
            session()->flash('belum_klaim', presensi::where('card_id', $card_id->id)->where('reward',0)->where('status',2)->where('status_approve',1)->count());

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
                        'rombongan' =>  $request->rombongan,
                    ]
                );
        }


        $cards = Card::where('cards.id', $request->card_id)
            ->join('card_levels', 'cards.level', '=', 'card_levels.id')
            ->select('card_levels.*', 'card_levels.nama')
            ->get();

        $phone = card::where('id',$request->card_id)->first()->hp;
        $phone = $this->formatNomor($phone);
        
        $api_key_wa = "u2a53a9beb36e4f5.7dc9be52f701442cafbf96cc899838f8"; 
        $url_wa = 'https://wa5901.oneapi.my.id/api/v1/messages';

        $client = new MessageBuilder([
            'api_url' => $url_wa,
            'api_key' => $api_key_wa,
        ]);

        $belanja_rp = $this->rupiah($belanja);
        $rombongan = $request->rombongan;
        $text = $client->to($phone)
            ->content("
                Sugeng Rawuh Dhateng  Kampoeng Banana Krezzz Cabang (x) &#13;&#13;• Rombongan : $rombongan &#13;• Tabuh : ".date("Y-m-d")."&#13;• Total Belanja : $belanja_rp &#13;&#13;Matur Suwun sampun pinarak Kampoeng Banana Krezzz🙏🏻☺️
                ")
            ->save();

        $messages = [$text];
        [$delivery, $errors] = $client->send($messages);


        session()->flash('level', $cards);
        session()->flash('pres', true);
        session()->flash('nomor', 1);
        session()->flash('presensis', presensi::where('card_id', $request->card_id)->latest()->get());
        session()->flash('jumlah', presensi::where('card_id', $request->card_id)->count());
        session()->flash('total_card', presensi::where('card_id',  $request->card_id)->where('status', 2)->count());
        session()->flash('total_crew', presensi::where('card_id',  $request->card_id)->where('status', 1)->count());
        session()->flash('crews', card::where('id', $request->card_id)->get());
        session()->flash('min_presensi', $min_presensi);
        session()->flash('presensi_reward', presensi::where('card_id', $request->card_id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
        session()->flash('rewards', reward::where('card_id',  $request->card_id)->get());
        session()->flash('stores', store::get());
        session()->flash('marketing', User::where('id', $request->user_id)->get('nama'));
        session()->flash('marketings', User::where('level', 'marketing')->get());
        return back()->with('berhasil_update_crew', 'oke');
    }

    public function formatNomor($phone) {
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
        
        $belanja_rp = presensi::where('card_id', $request->card_id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->sum('belanja');
        $belanja_rp = $this->rupiah($belanja_rp);
        presensi::where('card_id', $request->card_id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->update(['reward' => true]);
    
        $phone = card::where('id',$request->card_id)->first()->hp;
        $phone = $this->formatNomor($phone);
        
        $api_key_wa = "u2a53a9beb36e4f5.7dc9be52f701442cafbf96cc899838f8"; 
        $url_wa = 'https://wa5901.oneapi.my.id/api/v1/messages';

        $client = new MessageBuilder([
            'api_url' => $url_wa,
            'api_key' => $api_key_wa,
        ]);

        $text = $client->to($phone)
            ->content("Klaim absensi panjenengan sampun sukses! &#13;Wonten ing Kampoeng Banana Krezzz Cabang (×) &#13;&#13;Total Belanja : $belanja_rp &#13;&#13;Matur Suwun, &#13;Dipuntenggo karawuhan saklajengipun🙏🏻☺️")
            ->save();

        $messages = [$text];
        [$delivery, $errors] = $client->send($messages);


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
        session()->flash('presensi_reward', presensi::where('card_id', $request->card_id)->where('status', 2)->where('status_approve', 1)->where('reward', 0)->count());
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
            session()->flash('sudah_klaim', presensi::where('card_id', $card->id)->where('reward',1)->count());
            session()->flash('belum_klaim', presensi::where('card_id', $card->id)->where('reward',0)->where('status',2)->count());
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

    function rupiah($angka){
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
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


class MessageBuilder 
{
    private $apiKey;
    private $apiUrl;

    private $messageType;
    private $to;
    private $recipientType;
    private $headerType;
    private $headerValue;
    private $bodyValue;
    private $footerValue;
    private $buttons = [];
    private $templateDevButtons = [];
    private $sections = [];
    private $sectionButtonLabel;
    private $messages = [];
    private $senderClient = false;

    private $errors;

    public function __construct(array $args) {
        $this->apiKey = $args['api_key'] ?? '';
        $this->apiUrl = $args['api_url'] ?? '';

        $this->messageType = 'text';
    }

    public function type(string $type) {
        $this->messageType = $type;

        return $this;
    }
    
    public function to(?string $param) {
        $param = is_array($param) ? 
            implode(',', $this->filterPhones($param)) : 
            self::filterPhone($param);

        $this->to = $param;

        $recipientType = $this->strContains($param, '@g.us') ? 'group' : 'individual';
        $this->recipientType = $this->strContains($recipientType, ',') ? 'individual' : $recipientType;

        return $this;
    }

    public function header(string $param) {
        $this->headerType = !filter_var($param, FILTER_VALIDATE_URL) === false ? 'image' : 'text';
        $this->headerValue = $param;

        return $this;
    }

    public function attachmentUrl(string $param) {
        $this->headerType = 'link';
        $this->attachmentUrl = $param;

        return $this;
    }

    public function content(string $param) {
        $this->bodyValue = $param;

        return $this;
    }

    public function footer(string $param) {
        $this->footerValue = $param;

        return $this;
    }

    public function save() {
        $message = $this->buildMessageData();
        $this->resetMessage();

        return $message;
    }

    public function resetMessage() {
        $this->messageType = 'text';
        $this->to = null;
        $this->recipientType = 'individual';
        $this->headerType = null;
        $this->headerValue = null;
        $this->bodyValue = null;
        $this->footerValue = null;
        $this->buttons = [];
        $this->templateDevButtons = [];
        $this->sections = [];
        $this->sectionButtonLabel = null;
    }

    public function send($messageList = []) {

        if (count($messageList) > 0) {
            $this->messages = $messageList;
        }

        if (count($this->messages) == 0) {
            $this->messages[] = $this->buildMessageData();
            $this->resetMessage();
        }

        if (!$this->senderClient) {
            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey,
            ];

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL             => $this->apiUrl,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_ENCODING        => '',
                CURLOPT_MAXREDIRS       => 10,
                CURLOPT_TIMEOUT         => 0,
                CURLOPT_FOLLOWLOCATION  => true,
                CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST   => 'POST',
                CURLOPT_POSTFIELDS      => json_encode($this->messages),
                CURLOPT_HTTPHEADER      => $headers,
            ));
    
            $response = curl_exec($curl);
            curl_close($curl);

            if (!$response) {
                return [false, ['error' => 'Failed to send message']];
            }

            $response = json_decode($response, true);
            if (json_last_error() != JSON_ERROR_NONE) {
                return [false, ['error' => 'Failed to decode response']];
            }

            return [$response, null];
        }

        return $this->senderClient->send(
            $this->messages
        );

    }


    public function addButtonLink($label, $url) {
        if ($this->messageType == 'interactive_dev') {
            $this->templateDevButtons[] = [

                'type'      => 'link',
                'parameter' => [
                    'title' => $label,
                    'value' => $url,
                ],
            ];
        }
        
        return $this;
    }

    
    public function addButtonCall($label, $url) {
        if ($this->messageType == 'interactive_dev') {
            $this->templateDevButtons[] = [
                'type'      => 'call',
                'parameter' => [
                    'title' => $label,
                    'value'  => $url,
                ],
            ];
        }
        
        return $this;
    }



    private function buildTextMessage() {
        return [
            'text' => [
                'body' => $this->bodyValue,
            ]
        ];
    }
    
    private function buildImageMessage() {
        return [
            'image' => [
                'link' => $this->attachmentUrl,
                'caption' => $this->bodyValue,
            ]
        ];
    }

    private function buildDocMessage() {
        return [
            'document' => [
                'link' => $this->attachmentUrl,
            ]
        ];
    }

    private function buildTemplateDevMessage() {
        $output = [
            'header' => [
                'type' => $this->headerType,
                'parameter' => ['value' => $this->headerValue],
            ],
            'body' => [
                'type' => 'text',
                'parameter' => ['value' => $this->bodyValue],
            ],
        ];

        if (!empty($this->footerValue)) {
            $output = array_merge($output, [
                'footer' => [
                    'type' => 'text',
                    'parameter' => ['value' => $this->footerValue],
                ],
            ]);
        }

        if (count($this->templateDevButtons) > 0) {
            $output = array_merge($output, [
                'action' => ['buttons' => $this->templateDevButtons],
            ]);
        }

        return ['interactive_dev' => $output];
    }


    private function buildMessageData() {

        switch ($this->messageType) {
            case 'image':
                $message = $this->buildImageMessage();
                break;
            
            case 'document':
                $message = $this->buildDocMessage();
                break;
                
            case 'interactive_dev':
                $message = $this->buildTemplateDevMessage();
                break;
                
            default:
                $message = $this->buildTextMessage();
                break;
        }

        $fields = [
            'type' => $this->messageType,
            'to' => $this->to,
            'recipient_type' => $this->recipientType,
        ];

        
        return array_merge($fields, $message);
    }
   
    private function strContains($string, $search) {
        return strpos($string, $search) !== false;
    }

    public static function filterPhone(string $phone) {
        $phoneStr = preg_replace('/[^0-9]+/', '', $phone);
        if (substr($phoneStr, 0, 2) == '08') {
            $phoneStr = '628' . substr($phoneStr, 2);
        }
        
        if (strpos($phone, '@g.us') == false) {
            $phoneStr .= '@g.us';
        }

        return $phone;
    }
    
    private function filterPhones(array $phones) {
        return array_walk_recursive($phones, function(&$v, $k) { 
                $v = self::filterPhone($v); 
            }
        );
    }

}
