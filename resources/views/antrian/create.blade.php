@section('js')
 <script type="text/javascript">
   $(document).on('click', '.pilih', function (e) {
                document.getElementById("dokter_judul").value = $(this).attr('data-dokter_judul');
                document.getElementById("dokter_id").value = $(this).attr('data-dokter_id');
                $('#myModal').modal('hide');
            });

            $(document).on('click', '.pilih_pasien', function (e) {
                document.getElementById("pasien_id").value = $(this).attr('data-pasien_id');
                document.getElementById("pasien_nama").value = $(this).attr('data-pasien_nama');
                $('#myModal2').modal('hide');
            });
          
             $(function () {
                $("#lookup, #lookup2").dataTable();
            });

        </script>

@stop
@section('css')

@stop
@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('antrian.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
<div class="row">
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Tambah Antrian Baru</h4>
                    
                        <div class="form-group{{ $errors->has('kode_antrian') ? ' has-error' : '' }}">
                            <label for="kode_antrian" class="col-md-4 control-label">Kode antrian</label>
                            <div class="col-md-6">
                                <input id="kode_antrian" type="text" class="form-control" name="kode_antrian" value="{{ $kode }}" required readonly="">
                                @if ($errors->has('kode_antrian'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('kode_antrian') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('poli') ? ' has-error' : '' }}">
                            <label for="poli" class="col-md-4 control-label">Poli</label>
                            <div class="col-md-6">
                                <input id="poli" type="text" class="form-control" name="poli" value="{{ old('poli') }}">
                                @if ($errors->has('poli'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('poli') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('jam') ? ' has-error' : '' }}">
                            <label for="jam" class="col-md-4 control-label">Pukul</label>
                            <div class="col-md-6">
                                <input id="jam" type="text" class="form-control" name="jam" value="{{ old('jam') }}">
                                @if ($errors->has('jam'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('jam') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('tgl_antrian') ? ' has-error' : '' }}">
                            <label for="tgl_antrian" class="col-md-4 control-label">Tanggal Antrian</label>
                            <div class="col-md-3">
                                <input id="tgl_antrian" type="date" class="form-control" name="tgl_antrian" value="{{ date('Y-m-d', strtotime(Carbon\Carbon::today()->toDateString())) }}" required @if(Auth::user()->level == 'user') readonly @endif>
                                @if ($errors->has('tgl_antrian'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tgl_antrian') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        

                        <div class="form-group{{ $errors->has('dokter_id') ? ' has-error' : '' }}">
                            <label for="dokter_id" class="col-md-4 control-label">dokter</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                <input id="dokter_judul" type="text" class="form-control" readonly="" required>
                                <input id="dokter_id" type="hidden" name="dokter_id" value="{{ old('dokter_id') }}" required readonly="">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info btn-secondary" data-toggle="modal" data-target="#myModal"><b>Cari Dokter</b> <span class="fa fa-search"></span></button>
                                </span>
                                </div>
                                @if ($errors->has('dokter_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('dokter_id') }}</strong>
                                    </span>
                                @endif
                                 
                            </div>
                        </div>
                        

                        @if(Auth::user()->level == 'admin')
                        <div class="form-group{{ $errors->has('pasien_id') ? ' has-error' : '' }}">
                            <label for="pasien_id" class="col-md-4 control-label">pasien</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                <input id="pasien_nama" type="text" class="form-control" readonly="" required>
                                <input id="pasien_id" type="hidden" name="pasien_id" value="{{ old('pasien_id') }}" required readonly="">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-warning btn-secondary" data-toggle="modal" data-target="#myModal2"><b>Cari pasien</b> <span class="fa fa-search"></span></button>
                                </span>
                                </div>
                                @if ($errors->has('pasien_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pasien_id') }}</strong>
                                    </span>
                                @endif
                                 
                            </div>
                        </div>
                        @else
                        <div class="form-group{{ $errors->has('pasien_id') ? ' has-error' : '' }}">
                            <label for="pasien_id" class="col-md-4 control-label">pasien</label>
                            <div class="col-md-6">
                                <input id="pasien_nama" type="text" class="form-control" readonly="" value="{{Auth::user()->pasien->nama}}" required>
                                <input id="pasien_id" type="hidden" name="pasien_id" value="{{ Auth::user()->pasien->id }}" required readonly="">
                              
                                @if ($errors->has('pasien_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pasien_id') }}</strong>
                                    </span>
                                @endif
                                 
                            </div>
                        </div>
                        @endif


                        @if(Auth::user()->level == 'admin')
                         <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status" class="col-md-4 control-label">Status</label>
                            <div class="col-md-6">
                            
                            <select class="form-control" name="status" required="">
                            
                                <option value="status">Pasien Baru</option>
                                <option value="status">Pasien Lama</option>
                                
                            </select>
                            </div>
                        </div>
                        @else
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status" class="col-md-4 control-label">Status</label>
                            <div class="col-md-6">
                            <select class="form-control" name="status" required="">
                                <option value="status">Pasien Baru</option>          
                            </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group{{ $errors->has('ket') ? ' has-error' : '' }}">
                            <label for="ket" class="col-md-4 control-label">Keterangan</label>
                            <div class="col-md-6">
                                <input id="ket" type="text" class="form-control" name="ket" value="{{ old('ket') }}">
                                @if ($errors->has('ket'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ket') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="submit">
                                    Submit
                        </button>
                        <button type="reset" class="btn btn-danger">
                                    Reset
                        </button>
                        <a href="{{route('antrian.index')}}" class="btn btn-light pull-right">Back</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

</div>
</form>


  <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content" style="background: #fff;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Dokter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                        <table id="lookup" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Dokter</th>
 
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dokters as $data)
                                <tr class="pilih" data-dokter_id="<?php echo $data->id; ?>" data-dokter_judul="<?php echo $data->nama_dokter; ?>" >
                                    <td>@if($data->cover)
                            <img src="{{url('images/dokter/'. $data->cover)}}" alt="image" style="margin-right: 10px;" />
                          @else
                            <img src="{{url('images/dokter/default.png')}}" alt="image" style="margin-right: 10px;" />
                          @endif
                          {{$data->nama_dokter}}</td>
                            
                          <td>{{$data->ket}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>  
                    </div>
                </div>
            </div>
        </div>


  <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content" style="background: #fff;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Pasien</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                        <table id="lookup" class="table table-bordered table-hover table-striped">
                            <thead>
                        <tr>
                          <th>
                            Nama
                          </th>
                         
                          <th>
                            Jenis Kelamin
                          </th>
                        </tr>
                      </thead>
                            <tbody>
                                @foreach($pasiens as $data)
                                <tr class="pilih_pasien" data-pasien_id="<?php echo $data->id; ?>" data-pasien_nama="<?php echo $data->nama; ?>" >
                                    <td class="py-1">
                          @if($data->user->gambar)
                            <img src="{{url('images/user', $data->user->gambar)}}" alt="image" style="margin-right: 10px;" />
                          @else
                            <img src="{{url('images/user/default.png')}}" alt="image" style="margin-right: 10px;" />
                          @endif

                            {{$data->nama}}
                          </td>
                        

                          <td>
                            {{$data->jk === "L" ? "Laki - Laki" : "Perempuan"}}
                          </td>
                        </tr>
                                @endforeach
                            </tbody>
                        </table>  
                    </div>
                </div>
            </div>
        </div>
@endsection