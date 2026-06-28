<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorecardRequest;
use App\Http\Requests\UpdatecardRequest;

use App\Models\card;
use App\Models\marketing;
use App\Models\store;
use App\Models\presensi;
use App\Models\reward;
use App\Models\setting;
use App\Models\User;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function index()
    {
        $db = Store::where('id', auth()->user()->store_id)->first(); // Menggunakan 'Store' dengan huruf kapital dan menambahkan '->first()' untuk mendapatkan satu hasil

        $store = $db->nama;
        $alamat = $db->alamat;

        return view('card.home', [
            'title' => 'Registrasi Kartu',
            'store' => $store,
            'alamat' => $alamat
        ]);
    }
    public function cari_kartu()
    {
        $db = Store::where('id', auth()->user()->store_id)->first(); // Menggunakan 'Store' dengan huruf kapital dan menambahkan '->first()' untuk mendapatkan satu hasil

        $store = $db->nama;
        $alamat = $db->alamat;

        return view('card.cari_kartu', [
            'title' => 'Cari Kartu',
            'store' => $store,
            'alamat' => $alamat,
            'cards' => '',
            'presensis' => '',
        ]);
    }
    public function cari_kartu_show(Request $request)
    {
        $db = Store::where('id', auth()->user()->store_id)->first(); // Menggunakan 'Store' dengan huruf kapital dan menambahkan '->first()' untuk mendapatkan satu hasil

        $store = $db->nama;
        $alamat = $db->alamat;

        $cards = Card::where('nama', 'LIKE', '%' . $request->nama . '%') // Pencarian yang mirip
            ->orWhere('nama', 'LIKE', $request->nama) // Pencarian sama
            ->orWhere('nik', 'LIKE', '%' . $request->nama . '%') // Pencarian sama
            ->orWhere('nik', 'LIKE', $request->nama) // Pencarian sama
            ->orWhere('nomor', 'LIKE', '%' . $request->nama . '%') // Pencarian sama
            ->orWhere('nomor', 'LIKE', $request->nama) // Pencarian sama
            ->get();

        $presensis = presensi::all();

        session()->flash('hasil', true);
        return view('card.cari_kartu', [
            'title' => 'Cari Kartu',
            'store' => $store,
            'alamat' => $alamat,
            'cards' => $cards,
            'nama' => $request->nama,
            'presensis' => $presensis,
        ]);
    }
    public function add_card(Request $request)
    {
        $timestamp = time();
        $waktu = date('H:i', $timestamp);

        $today = Carbon::now();
        $tgl = $today->format('d M Y');



        // Cek apakah card_id ditemukan dalam tabel cards

        $cards = card::where('nomor', $request->nomor)->join('card_levels', 'cards.level', '=', 'card_levels.id')
            ->select('cards.nomor', 'card_levels.nama')
            ->get();



        if (!$cards->isEmpty()) {
            session()->flash('info', true);
            session()->flash('level', $cards);
            session()->flash('cards', card::where('nomor', $request->nomor)->get());
            return back()->with('sudah_regis', 'oke');
        } else {

            card::create([
                'nomor' =>  $request->nomor,
            ]);
            $cards = card::where('nomor', $request->nomor)->join('card_levels', 'cards.level', '=', 'card_levels.id')
                ->select('cards.nomor', 'card_levels.nama')
                ->get();
            session()->flash('info', true);
            session()->flash('level', $cards);
            session()->flash('cards', card::where('nomor', $request->nomor)->get());



            return back()->with('berhasil_regis', 'oke');
        }
    }
    public function crew_update(Request $request)
    {
        $db = setting::value('belanja');
        $min_presensi = Setting::value('min_presensi');
        $belanja = $request->belanja;
        if ($db >= $belanja) {
            $status = 1;
        }
        if ($db < $belanja) {
            $status = 2;
        }

        card::where('id', $request->id_card)
            ->update(
                [
                    'nama' =>  $request->nama,
                    'nik' =>  $request->nik,
                    'asal' =>  $request->asal,
                    'jk' =>  $request->jk,
                    'hp' =>  $request->hp,
                    'email' =>  $request->email,
                    'po' =>  $request->po,
                    'user_id' =>  $request->user_id,
                ]
            );

        $cards = card::where('nomor', $request->nomor)->join('card_levels', 'cards.level', '=', 'card_levels.id')
            ->select('card_levels.*', 'card_levels.nama')
            ->get();

        session()->flash('level', $cards);
        session()->flash('pres', true);
        session()->flash('nomor', 1);
        session()->flash('presensis', presensi::where('card_id', $request->id_card)->latest()->get());
        session()->flash('jumlah', presensi::where('card_id', $request->id_card)->count());
        session()->flash('crews', card::where('nomor', $request->nomor)->get());
        session()->flash('total_card', presensi::where('card_id',  $request->card_id)->where('status', 2)->count());
        session()->flash('total_crew', presensi::where('card_id',  $request->card_id)->where('status', 1)->count());
        session()->flash('min_presensi', $min_presensi);
        session()->flash('stores', store::get());
        session()->flash('presensi_reward', presensi::where('card_id', $request->card_id)->where('status', 2)->where('reward', 0)->count());
        session()->flash('rewards', reward::where('card_id', $request->card_id)->get());


        session()->flash('marketing', User::where('id', $request->user_id)->get('nama'));
        session()->flash('marketings', User::where('level', 'marketing')->get());
        return back()->with('berhasil_update_crew', 'oke');
    }


    public function card_update(Request $request)
    {
        $db = setting::value('belanja');
        $min_presensi = Setting::value('min_presensi');
        $belanja = $request->belanja;
        if ($db >= $belanja) {
            $status = 1;
        }
        if ($db < $belanja) {
            $status = 2;
        }
        $card_id_old = $request->id_card_old;
        $card = Card::where('id', $card_id_old)->first();
        if ($request->level == 3) {
            // Kode jika validasi gagal
            $cards = card::where('nomor', $request->nomor)->join('card_levels', 'cards.level', '=', 'card_levels.id')
                ->select('card_levels.*', 'card_levels.nama')
                ->get();





            session()->flash('level', $cards);
            session()->flash('pres', true);
            session()->flash('nomor', 1);
            session()->flash('presensis', presensi::where('card_id', $card_id_old)->latest()->get());
            session()->flash('jumlah', presensi::where('card_id', $card_id_old)->count());
            session()->flash('crews', card::where('id', $card_id_old)->get());
            session()->flash('total_card', presensi::where('card_id',  $request->card_id)->where('status', 2)->count());
            session()->flash('total_crew', presensi::where('card_id',  $request->card_id)->where('status', 1)->count());
            session()->flash('min_presensi', $min_presensi);
            session()->flash('stores', store::get());
            session()->flash('presensi_reward', presensi::where('card_id', $request->card_id)->where('status', 2)->where('reward', 0)->count());
            session()->flash('rewards', reward::where('card_id', $request->card_id)->get());


            session()->flash('marketing', User::where('id', $card->user_id)->get());
            session()->flash('marketings', User::where('level', 'marketing')->get());
            return back()->with('gagal_update_card_max', 'oke');
        } else {
            try {
                $request->validate([
                    'nomor' => 'unique:cards',
                ]);

                $level = $request->level + 1;
                // Kode jika validasi berhasil
                Card::where('id', $request->id_card)
                    ->update([
                        'nomor' => $request->nomor,
                        'level' => $level
                    ]);
                $cards = card::where('nomor', $request->nomor)->join('card_levels', 'cards.level', '=', 'card_levels.id')
                    ->select('card_levels.*', 'card_levels.nama')
                    ->get();

                session()->flash('level', $cards);
                session()->flash('pres', true);
                session()->flash('nomor', 1);
                session()->flash('presensis', presensi::where('card_id', $card_id_old)->latest()->get());
                session()->flash('jumlah', presensi::where('card_id', $card_id_old)->count());
                session()->flash('total_card', presensi::where('card_id',  $request->card_id)->where('status', 2)->count());
                session()->flash('total_crew', presensi::where('card_id',  $request->card_id)->where('status', 1)->count());
                session()->flash('min_presensi', $min_presensi);
                session()->flash('stores', store::get());
                session()->flash('presensi_reward', presensi::where('card_id', $request->card_id)->where('status', 2)->where('reward', 0)->count());
                session()->flash('rewards', reward::where('card_id', $request->card_id)->get());


                session()->flash('marketing', User::where('id', $card->user_id)->get());
                session()->flash('marketings', User::where('level', 'marketing')->get());
                session()->flash('crews', card::where('id', $card_id_old)->get());
                return back()->with('berhasil_update_card', 'oke');
            } catch (\Illuminate\Validation\ValidationException $exception) {
                // Kode jika validasi gagal
                $cards = card::where('nomor', $request->nomor)->join('card_levels', 'cards.level', '=', 'card_levels.id')
                    ->select('card_levels.*', 'card_levels.nama')
                    ->get();

                session()->flash('level', $cards);
                session()->flash('pres', true);
                session()->flash('nomor', 1);
                session()->flash('presensis', presensi::where('card_id', $card_id_old)->latest()->get());
                session()->flash('jumlah', presensi::where('card_id', $card_id_old)->count());
                session()->flash('crews', card::where('id', $card_id_old)->get());
                session()->flash('total_card', presensi::where('card_id',  $request->card_id)->where('status', 2)->count());
                session()->flash('total_crew', presensi::where('card_id',  $request->card_id)->where('status', 1)->count());
                session()->flash('min_presensi', $min_presensi);
                session()->flash('stores', store::get());
                session()->flash('presensi_reward', presensi::where('card_id', $request->card_id)->where('status', 2)->where('reward', 0)->count());
                session()->flash('rewards', reward::where('card_id', $request->card_id)->get());


                session()->flash('marketing', User::where('id', $card->user_id)->get());
                session()->flash('marketings', User::where('level', 'marketing')->get());
                return back()->with('gagal_update_card', 'oke');
            }
        }
    }











    public function act_update_kartu(Request $request)
    {

        $nomor = $request->nomor;
        $isCardNumberUsed = Card::where('nomor', $nomor)->exists();

        if ($isCardNumberUsed) {

            return back()->with('no', 'oke');
        } else {

            card::where('id', $request->id)
                ->update(
                    [
                        'nomor' =>  $nomor,

                    ]
                );
            return back()->with('ok', 'oke');
        }
    }


    public function update_kartu()
    {
        $db = Store::where('id', auth()->user()->store_id)->first(); // Menggunakan 'Store' dengan huruf kapital dan menambahkan '->first()' untuk mendapatkan satu hasil

        if (auth()->user()->level == 'master') {

            $store = 'Master';
            $alamat = '-';
        } else {
            $store = $db->nama;
            $alamat = $db->alamat;
        }

        $presensi = presensi::all();

        $cards = presensi::get();
        $cardIds = $cards->pluck('card_id')->toArray();
        $kartu_aktif = card::whereIn('id', $cardIds)->get();


        return view('staf.users.update_kartu', [
            'title' => 'Update Kartu',
            'store' => $store,
            'alamat' => $alamat,
            'kartu_aktif' => $kartu_aktif,
            'presensi' => $presensi,
        ]);
    }


    public function search_kartu(Request $request)
    {
        $db = Store::where('id', auth()->user()->store_id)->first(); // Menggunakan 'Store' dengan huruf kapital dan menambahkan '->first()' untuk mendapatkan satu hasil

        if (auth()->user()->level == 'master') {

            $store = 'Master';
            $alamat = '-';
        } else {
            $store = $db->nama;
            $alamat = $db->alamat;
        }


        $keyword = $request->input('keyword');
        $presensi = presensi::all();


        // Perform the search on the Card model
        $cards = Card::where('nomor', 'LIKE', "%$keyword%")
            ->orWhere('nik', 'LIKE', "%$keyword%")
            ->orWhere('nama', 'LIKE', "%$keyword%")
            ->orWhere('asal', 'LIKE', "%$keyword%")
            ->orWhere('hp', 'LIKE', "%$keyword%")
            ->orWhere('email', 'LIKE', "%$keyword%")
            ->get();


        return view('staf.users.update_kartu', [
            'title' => 'Update Kartu',
            'store' => $store,
            'alamat' => $alamat,
            'kartu_aktif' => $cards,
            'keyword' => $keyword,
            'presensi' => $presensi,
        ]);
    }


    public function kartu()
    {
        $db = Store::where('id', auth()->user()->store_id)->first(); // Menggunakan 'Store' dengan huruf kapital dan menambahkan '->first()' untuk mendapatkan satu hasil

        if (auth()->user()->level == 'master') {

            $store = 'Master';
            $alamat = '-';
        } else {
            $store = $db->nama;
            $alamat = $db->alamat;
        }



        $cards = presensi::get();
        $cardIds = $cards->pluck('card_id')->toArray();
        $kartu_aktif = card::whereIn('id', $cardIds)->get();
        $kartu_pasif = card::whereNotIn('id', $cardIds)->get();


        return view('staf.users.kartu', [
            'title' => 'Registrasi Kartu',
            'store' => $store,
            'alamat' => $alamat,
            'kartu_pasif' => $kartu_pasif,
            'kartu_aktif' => $kartu_aktif,
        ]);
    }



    public function hapus_kartu(Request $request)
    {
        $card = Card::findOrFail($request->id);

        // Menghapus data dari tabel card
        $card->delete();

        return redirect()->back()->with('hapus_kartu', 'Kartu berhasil dihapus');
    }
    public function presensi_kartu(Request $request)
    {
        $db = Store::where('id', auth()->user()->store_id)->first(); // Menggunakan 'Store' dengan huruf kapital dan menambahkan '->first()' untuk mendapatkan satu hasil

        $store = $db->nama;
        $alamat = $db->alamat;

        $filter = $request->filter;
        if ($filter == 1) {
            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');

            $kartu_pasif = Presensi::where('store_id', auth()->user()->store_id)
                ->whereDate('created_at', '>=', $start_date)
                ->whereDate('created_at', '<=', $end_date)
                ->get();
        } else {

            $today = Carbon::today(); // Ambil tanggal hari ini

            $kartu_pasif = Presensi::where('store_id', auth()->user()->store_id)
                ->whereDate('created_at', $today)
                ->get();
        }


        $marketing = marketing::all();
        $stores = store::all();
        $card = card::all();

        return view('staf.users.presensi', [
            'title' => 'Registrasi Kartu',
            'store' => $store,
            'store' => $store,
            'users' => $kartu_pasif,
            'marketings' => $marketing,
            'stores' => $stores,
            'cards' => $card,
            'filter' => $filter,
        ]);
    }
}
