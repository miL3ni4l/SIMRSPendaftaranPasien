<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Pasien;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Redirect;
use Auth;
use DB;
use RealRashid\SweetAlert\Facades\Alert;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        if(Auth::user()->level == 'user') {
            Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
            return redirect()->to('/');
        }

        $datas = Pasien::get();
        return view('pasien.index', compact('datas'));
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

        $users = User::WhereNotExists(function($query) {
                        $query->select(DB::raw(1))
                        ->from('pasien')
                        ->whereRaw('pasien.user_id = users.id');
                     })->get();
        return view('pasien.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = Pasien::where('nip',$request->input('nip'))->count();

        if($count>0){
            Session::flash('message', 'Already exist!');
            Session::flash('message_type', 'danger');
            return redirect()->to('pasien');
        }

        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:20|unique:pasien'
        ]);

        Pasien::create($request->all());

        alert()->success('Berhasil.','Data telah ditambahkan!');
        return redirect()->route('pasien.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $data = Pasien::findOrFail($id);

        return view('pasien.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        if((Auth::user()->level == 'user') && (Auth::user()->id != $id)) {
                Alert::info('Oopss..', 'Anda dilarang masuk ke area ini.');
                return redirect()->to('/');
        }

        $data = pasien::findOrFail($id);
        $users = User::get();
        return view('pasien.edit', compact('data', 'users'));
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
        pasien::find($id)->update($request->all());

        alert()->success('Berhasil.','Data telah diubah!');
        return redirect()->to('pasien');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        pasien::find($id)->delete();
        alert()->success('Berhasil.','Data telah dihapus!');
        return redirect()->route('pasien.index');
    }
}
