<?php

use App\Exports\PresensiExport;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\KlaimController;
use App\Http\Controllers\marketing;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/presensi', [PresensiController::class, 'index'])->middleware('auth');
Route::get('/card', [CardController::class, 'index'])->middleware('auth');

Route::get('/cari_cardm', [PresensiController::class, 'cari_cardm']);


Route::get('/laporan', function () {
    return view('staf.crew.laporan');
});


Route::get('/marketing', function () {
    return view('marketing.home');
});

Route::get('/fee', function () {
    return view('fee.home');
});



//auth
Route::get('/', [Controller::class, 'login'])->name('login');
Route::post('/auth', [Controller::class, 'auth']);
Route::get('/logout', [Controller::class, 'logout'])->middleware('auth');

//presensi
Route::post('/add_presensi', [PresensiController::class, 'add_presensi'])->middleware('auth');
Route::post('/add_belanja', [PresensiController::class, 'add_belanja'])->middleware('auth');
Route::get('/approve_presence/{id}', [PresensiController::class, 'approve_presence'])->middleware('auth');
Route::get('/add_presensi_id', [PresensiController::class, 'add_presensi_id'])->middleware('auth');

//regis kartu
Route::get('/add_card', [CardController::class, 'add_card'])->middleware('auth');
Route::get('/cari_kartu', [CardController::class, 'cari_kartu'])->middleware('auth');
Route::get('/cari_kartu_act', [CardController::class, 'cari_kartu_show'])->middleware('auth');
Route::get('/detail_card', [PresensiController::class, 'detail_card'])->middleware('auth');

//Klaim Reward 
Route::get('/klaim_reward', [PresensiController::class, 'klaim_reward'])->middleware('auth');

//Crew
Route::post('/cerew_update', [CardController::class, 'crew_update'])->middleware('auth');
Route::post('/card_update', [CardController::class, 'card_update'])->middleware('auth');


//regis kartu
Route::get('/fee', [PresensiController::class, 'fee'])->middleware('auth');
Route::post('/fee_update', [PresensiController::class, 'fee_update'])->middleware('auth');
//filter fee
Route::get('/fee.filter', [PresensiController::class, 'fee_filter'])->middleware('auth');
Route::get('/marketing', [MarketingController::class, 'index'])->middleware('auth');



//admin
Route::get('/admin', [AdminController::class, 'index'])->middleware('auth');
Route::get('/crew', [AdminController::class, 'crew'])->middleware('auth');
Route::get('/users', [AdminController::class, 'users'])->middleware('auth');
Route::post('/users.add', [AdminController::class, 'users_add'])->middleware('auth');
Route::post('/users.update', [AdminController::class, 'users_update'])->middleware('auth');

Route::get('/marketing', [AdminController::class, 'marketing'])->middleware('auth');
Route::post('/marketing.update', [AdminController::class, 'marketing_update'])->middleware('auth');
Route::post('/marketing.add', [AdminController::class, 'marketing_add'])->middleware('auth');


Route::get('/kartu', [CardController::class, 'kartu'])->middleware('auth');
Route::get('/update_kartu', [CardController::class, 'update_kartu'])->middleware('auth');
Route::get('/search_kartu', [CardController::class, 'search_kartu'])->name('cards.search')->middleware('auth');
Route::post('/act.update.kartu', [CardController::class, 'act_update_kartu'])->middleware('auth');
Route::get('/hapus.kartu', [CardController::class, 'hapus_kartu'])->middleware('auth');



Route::get('/presensi_kartu', [CardController::class, 'presensi_kartu'])->middleware('auth');

Route::post('/update.belanja', [PresensiController::class, 'update_belanja'])->middleware('auth');

Route::get('/klaim_presensi', [KlaimController::class, 'klaim_presensi'])->middleware('auth');

//setting
Route::get('/setting', [SettingController::class, 'index'])->middleware('auth');
Route::post('/update.setting', [SettingController::class, 'update'])->middleware('auth');

//master

Route::get('/master.users', [AdminController::class, 'master_users'])->middleware('auth');
Route::post('/master.users.update', [AdminController::class, 'mster_users_update'])->middleware('auth');


//export

Route::get('/download_presensi', function () {

    
    $alternatif = request()->input('alternatif', 1);
   
    if ($alternatif !== 1) {
        //echo  $alternatif;
        session()->put('start_date', request()->input('start_date'));
        session()->put('end_date', request()->input('end_date'));
        return redirect('/dpresensi');
    } else {
        $tanggal = request()->input('created_at', now()->toDateString());
        $presensiExport = new PresensiExport;
        return Excel::download($presensiExport, 'Presensi.xlsx');
    }
})->middleware('auth');

Route::get('/dpresensi', function () {
    $start_date = session()->get('start_date', now()->toDateString());
    $end_date = session()->get('end_date', now()->toDateString());
    $presensiExport = new PresensiExport;

    return $presensiExport->view();

    session()->forget(['start_date', 'end_date']);
})->middleware('auth');