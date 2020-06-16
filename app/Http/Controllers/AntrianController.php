<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\dokter;
use App\pasien;
use App\antrian;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class antrianController extends Controller
{
    /**
     * Display a listing of the resource.
     *cara
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->level == 'user')
        {
            $datas = antrian::where('pasien_id', Auth::user()->pasien->id)
                                ->get();
        } else {
            $datas = antrian::get();
        }
        return view('antrian.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $getRow = antrian::orderBy('id', 'DESC')->get();
        $rowCount = $getRow->count();
        
        $lastId = $getRow->first();

        $kode = "UKDW00001";
        
        if ($rowCount > 0) {
            if ($lastId->id < 9) {
                    $kode = "UKDW0000".''.($lastId->id + 1);
            } else if ($lastId->id < 99) {
                    $kode = "UKDW000".''.($lastId->id + 1);
            } else if ($lastId->id < 999) {
                    $kode = "UKDW00".''.($lastId->id + 1);
            } else if ($lastId->id < 9999) {
                    $kode = "UKDW0".''.($lastId->id + 1);
            } else {
                    $kode = "UKDW".''.($lastId->id + 1);
            }
        }

        $dokters = dokter::where('jumlah_dokter', '>', 0)->get();
        $pasiens = pasien::get();
        return view('antrian.create', compact('dokters', 'kode', 'pasiens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_antrian' => 'required|string|max:255',
            'tgl_antrian' => 'required',
            'rupiah' => 'required',
            'ket' => 'required',
            'dokter_id' => 'required',
            'pasien_id' => 'required',

        ]);

        $antrian = antrian::create([
                'kode_antrian' => $request->get('kode_antrian'),
                'tgl_antrian' => $request->get('tgl_antrian'),
                'rupiah' => $request->get('rupiah'),
                'ket' => $request->get('ket'),
                'dokter_id' => $request->get('dokter_id'),
                'pasien_id' => $request->get('pasien_id'),
                'status' => 'belum'
            ]);

        $antrian->dokter->where('id', $antrian->dokter_id)
                        ->update([
                            'jumlah_dokter' => ($antrian->dokter->jumlah_dokter - 1),
                            ]);

        alert()->success('Berhasil.','Data telah ditambahkan!');
        return redirect()->route('antrian.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $data = antrian::findOrFail($id);


        if((Auth::user()->level == 'user') && (Auth::user()->pasien->id != $data->pasien_id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }


        return view('antrian.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $data = antrian::findOrFail($id);

        if((Auth::user()->level == 'user') && (Auth::user()->pasien->id != $data->pasien_id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        return view('dokter.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $antrian = antrian::find($id);

        $antrian->update([
                'status' => 'lunas'
                ]);

        $antrian->dokter->where('id', $antrian->dokter->id)
                        ->update([
                            'jumlah_dokter' => ($antrian->dokter->jumlah_dokter + 1),
                            ]);

        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->route('antrian.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        antrian::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('antrian.index');
    }
}
