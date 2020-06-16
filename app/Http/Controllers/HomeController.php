<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Antrian;
use App\Pasien;
use App\Dokter;
use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $antrian = Antrian::get();
        $pasien   = Pasien::get();
        $dokter      = Dokter::get();
        if(Auth::user()->level == 'user')
        {
            $datas = Antrian::where('Pasien Lama', 'Pasien Baru')
                                ->where('pasien_id', Auth::user()->pasien->id)
                                ->get();
        } else {
            $datas = Antrian::where('status', 'Pasien Lama')->get();
        }
        return view('home', compact('antrian', 'pasien', 'dokter', 'datas'));
    }
}
