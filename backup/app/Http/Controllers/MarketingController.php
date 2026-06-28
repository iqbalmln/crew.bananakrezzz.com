<?php

namespace App\Http\Controllers;

use App\Models\card;
use App\Models\card_level;
use App\Models\presensi;
use App\Models\User;
use DateTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class MarketingController extends Controller
{


    public function index()
    {
        $today = Carbon::today();
        //$presensi=Presensi::whereDate('created_at', $today)->get();

        $cards = Card::where('user_id', Auth::user()->id)->get();
        $cardIds = $cards->pluck('id')->toArray();

        return view('marketing.home', [
            'presensis' => Presensi::whereIn('card_id', $cardIds)->whereDate('created_at', $today)->latest()->get(),
            'cards' => card::all(),
            'users' => User::all(),
            'info' => 'Data hari ini diurutkan dari yang terbaru',
            'levels' => card_level::all(),

        ]);
    }
}
