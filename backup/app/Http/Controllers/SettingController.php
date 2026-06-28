<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoresettingRequest;
use App\Http\Requests\UpdatesettingRequest;
use App\Models\setting;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
      
        $settings = setting::all();


        return view('staf.setting.index', [
            'store' => 'Master',
            'settings' =>  $settings,
        ]);
    }
    public function update(Request $request)
    {
      
        setting::where('id', $request->id)
            ->update(
                [
                    'belanja' => $request->belanja,
                    'min_presensi' =>  $request->min_presensi
                ]
            );

            return back()->with('berhasil_update', 'oke');
    }
}
