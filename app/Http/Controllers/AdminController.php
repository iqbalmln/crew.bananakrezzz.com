<?php

namespace App\Http\Controllers;

use App\Models\card;
use App\Models\card_level;
use App\Models\marketing;
use App\Models\presensi;
use App\Models\reward;
use App\Models\store;
use App\Models\User;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{


    public function index()
    {
        $today = Carbon::today();
        $cards = presensi::get();
        $cardIds = $cards->pluck('card_id')->toArray();
        $transaksi_now = Presensi::where('store_id', Auth::user()->store_id)->whereDate('created_at', $today)->count();
        $klaim_presensi = reward::where('store_id', Auth::user()->store_id)->whereDate('created_at', $today)->count();
        $users = User::where('store_id', Auth::user()->store_id)->count();
        $jml_cards = card::whereIn('id', $cardIds)->count();
        $card = card::count();
        $card_presensi_no = $card - $jml_cards;
        $store = Store::where('id', Auth::user()->store_id)->value('nama');
        $marketing = marketing::where('store_id', Auth::user()->store_id)->count();
        $marketings = marketing::all();

        return view('staf.home.index', [
            'presensis' => Presensi::where('store_id', Auth::user()->store_id)->whereDate('created_at', $today)->latest()->get(),
            'transaksi_now' => $transaksi_now,
            'cards' => card::all(),
            'users' => User::all(),
            'levels' => card_level::all(),
            'jml_cards' => card::count(),
            'card_presensi' => $jml_cards,
            'card_presensi_no' => $card_presensi_no,
            'store' => $store,
            'klaim_presensi' => $klaim_presensi,
            'users' => $users,
            'marketing' => $marketing,
            'mars' => $marketings,

        ]);
    }


    public function crew()
    {
        return view('staf.crew.crew', [
            'presensis' => Presensi::latest()->get(),
            'cards' => card::all(),
            'users' => User::all(),
            'levels' => card_level::all()

        ]);
    }

    public function users()
    {
        $users = User::where('store_id', Auth::user()->store_id)->get();

        $store = Store::where('id', Auth::user()->store_id)->value('nama');
        return view('staf.users.user', [
            'users' => $users,
            'store' => $store,


        ]);
    }
    public function marketing()
    {
        $users = marketing::where('store_id', Auth::user()->store_id)->get();
        $lokasi  = store::all();

        $store = Store::where('id', Auth::user()->store_id)->value('nama');
        return view('staf.users.marketing', [
            'users' => $users,
            'store' => $store,
            'lokasi' => $lokasi,

        ]);
    }
    public function users_add(Request $request)
    {

        $valid = $request->validate([
            'nama' => 'required',
            'hp' => 'required',
            'level' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);

        if($request->store_id==''){
            $valid['store_id'] = Auth::user()->store_id;
        }else{
            $valid['store_id'] = $request->store_id;
        }

      
        $valid['password'] = bcrypt($valid['password']);
        $valid['created_at'] = date('Y-m-d H:i:s');
        $valid['updated_at'] = date('Y-m-d H:i:s');


        if ($valid) {
            $id = User::insertGetId($valid);
            return back()->with('user.add', 'Akun Berhasil Dibuat');
        }
    }
    public function users_update(Request $request)
    {
        $valid = $request->validate([
            'nama' => 'required',
            'hp' => 'required',
            'level' => 'required',
            'password' => '',
        ]);

        $valid['created_at'] = date('Y-m-d H:i:s');
        $valid['updated_at'] = date('Y-m-d H:i:s');

        if (!empty($valid['password'])) {
            $valid['password'] = bcrypt($valid['password']);
        } else {
            unset($valid['password']);
        }

        if (!empty($valid)) {
            $id = User::where('id', $request->user_id)->update($valid);
            return back()->with('user.update', 'Akun Berhasil Diupdate');
        }
    }
    public function marketing_update(Request $request)
    {
        $valid = $request->validate([
            'nama' => 'required',
            'hp' => 'required',
            'store_id' => 'required',
        ]);

        $valid['created_at'] = date('Y-m-d H:i:s');
        $valid['updated_at'] = date('Y-m-d H:i:s');


         marketing::where('id', $request->user_id)->update($valid);
        return back()->with('user.update', 'Marketing Berhasil Diupdate');
    }
    public function marketing_add(Request $request)
    {

        $valid = $request->validate([
            'nama' => 'required',
            'hp' => 'required',
        ]);

        $valid['store_id'] = Auth::user()->store_id;
       
        $valid['created_at'] = date('Y-m-d H:i:s');
        $valid['updated_at'] = date('Y-m-d H:i:s');


        if ($valid) {
            $id = marketing::insertGetId($valid);
            return back()->with('user.add', 'Marketing Berhasil Dibuat');
        }
    }

    public function master_users()
    {
        $users = User::all();
        $stores = store::all();

       
        return view('staf.users.master_user', [
            'users' => $users,
            'stores' => $stores,
            'store' => '',


        ]);
    }

    public function mster_users_update(Request $request)
    {
        $valid = $request->validate([
            'nama' => 'required',
            'hp' => 'required',
            'level' => 'required',
            'store_id' => 'required',
            'password' => '',
        ]);

        $valid['created_at'] = date('Y-m-d H:i:s');
        $valid['updated_at'] = date('Y-m-d H:i:s');

        if (!empty($valid['password'])) {
            $valid['password'] = bcrypt($valid['password']);
        } else {
            unset($valid['password']);
        }

        if (!empty($valid)) {
            $id = User::where('id', $request->user_id)->update($valid);
            return back()->with('user.update', 'Akun Berhasil Diupdate');
        }
    }
}
