<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Dokter;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use Excel;
use RealRashid\SweetAlert\Facades\Alert;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $datas = Dokter::get();
        return view('dokter.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        return view('dokter.create');
    }

   
    public function import(Request $request)
    {
        $this->validate($request, [
            'importdokter' => 'required'
        ]);

        if ($request->hasFile('importdokter')) {
            $path = $request->file('importdokter')->getRealPath();

            $data = Excel::load($path, function($reader){})->get();
            $a = collect($data);

            if (!empty($a) && $a->count()) {
                foreach ($a as $key => $value) {
                    $insert[] = [
                            'nama_dokter' => $value->nama_dokter, 
                            'jumlah_dokter' => $value->jumlah_dokter, 
                            'poli' => $value->poli,
                            'ket' => $value->ket, 
                            'cover' => NULL];

                    Dokter::create($insert[$key]);
                        
                    }
                  
            };
        }
        alert()->success('Berhasil.','Data telah diimport!');
        return back();
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
            'nama_dokter' => 'required|string|max:255',
        ]);

        if($request->file('cover')) {
            $file = $request->file('cover');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak; 
            $request->file('cover')->move("images/dokter", $fileName);
            $cover = $fileName;
        } else {
            $cover = NULL;
        }

        Dokter::create([
                
                'nama_dokter' => $request->get('nama_dokter'),
                'jumlah_dokter' => $request->get('jumlah_dokter'),
                'poli' => $request->get('poli'),
                'ket' => $request->get('ket'),
                'cover' => $cover
            ]);

        alert()->success('Berhasil.','Data telah ditambahkan!');

        return redirect()->route('dokter.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->level == 'user') {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $data = Dokter::findOrFail($id);

        return view('dokter.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        if(Auth::user()->level == 'user') {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $data = Dokter::findOrFail($id);
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
        if($request->file('cover')) {
            $file = $request->file('cover');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak; 
            $request->file('cover')->move("images/dokter", $fileName);
            $cover = $fileName;
        } else {
            $cover = NULL;
        }

        Dokter::find($id)->update([
                 'nama_dokter' => $request->get('nama_dokter'),
                'jumlah_dokter' => $request->get('jumlah_dokter'),
                'poli' => $request->get('poli'),
                'ket' => $request->get('ket'),
                'cover' => $cover
                ]);

        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->route('dokter.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dokter::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('dokter.index');
    }
}
