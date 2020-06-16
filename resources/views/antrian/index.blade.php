
@section('js')
<script type="text/javascript">
  $(document).ready(function() {
    $('#table').DataTable({
      "iDisplayLength": 50
    });

} );
</script>
@stop
@extends('layouts.app')

@section('content')
<div class="row">

  <div class="col-lg-2">
    <a href="{{ route('antrian.create') }}" class="btn btn-primary btn-rounded btn-fw"><i class="fa fa-plus"></i> Tambah Antrian</a>
  </div>
    <div class="col-lg-12">
                  @if (Session::has('message'))
                  <div class="alert alert-{{ Session::get('message_type') }}" id="waktu2" style="margin-top:10px;">{{ Session::get('message') }}</div>
                  @endif
                  </div>
</div>

@if(Auth::user()->level == 'admin')
<div class="row" style="margin-top: 20px;">
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">

                <div class="card-body">
                  <h4 class="card-title">Data antrian</h4>
                  
                  <div class="table-responsive">
                    <table class="table table-striped" id="table">
                      <thead>
                        <tr>
                          <th>
                            Kode
                          </th>
                          <th>
                            Dokter
                          </th>
                          <th>
                            Pasien
                          </th>
                          <th>
                            Tanggal Antrian
                          </th>
                          <th>
                            Poli
                          </th>
                          <th>
                            Status
                          </th>
                          <th>
                            Ket
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach($datas as $data)
                        <tr>
                          <td class="py-1">
                          <a href="{{route('antrian.show', $data->id)}}"> 
                            {{$data->kode_antrian}}
                          </a>
                          </td>
                         
                          <td>
                            {{$data->dokter->nama_dokter}}
                          </td>
                         
                          <td>
                            {{$data->pasien->nama}}
                          </td>
              
                          <td>
                            {{date('d/m/y', strtotime($data->tgl_antrian))}}
                          </td>

                          <td>
                            {{$data->poli}}
                          </td>
              

                          <td>
                          @if($data->status == 'Pasien Baru')
                            <label class="badge badge-warning">Pasien Baru</label>
                          @else
                            <label class="badge badge-success">Pasien Lama</label>
                          @endif
                          </td>

                           <td>
                            {{$data->ket}}
                          </td>
                          <td>
                          @if(Auth::user()->level == 'admin')
                          <div class="btn-group dropdown">
                          <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                          </button>
                          <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
                          @if($data->status == 'Pasien Baru')
                          <form action="{{ route('antrian.update', $data->id) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <button class="dropdown-item" onclick="return confirm('Anda yakin data ini sudah Pasien Lama?')"> Sudah Pasien Lama
                            </button>
                          </form>
                          @endif
                            <form action="{{ route('antrian.destroy', $data->id) }}" class="pull-left"  method="post">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button class="dropdown-item" onclick="return confirm('Anda yakin ingin menghapus data ini?')"> Delete
                            </button>
                          </form>
                          </div>
                        </div>
                        @else
                        @if($data->status == 'Pasien Baru')
                        <form action="{{ route('antrian.update', $data->id) }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <button class="btn btn-info btn-xs" onclick="return confirm('Anda yakin data ini sudah Pasien Lama?')">Sudah Pasien Lama
                            </button>
                          </form>
                          @else
                          -
                          @endif
                        @endif
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>
               {{--  {!! $datas->links() !!} --}}
                </div>
              </div>
            </div>
          </div>
@else
<div class="row" style="margin-top: 20px;">
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">

                <div class="card-body">
                  <h4 class="card-title">Data antrian</h4>
                  
                  <div class="table-responsive">
                    <table class="table table-striped" id="table">
                      <thead>
                        <tr>
                          <th>
                            Kode
                          </th>
                          <th>
                            Dokter
                          </th>
                         
                          <th>
                            Tanggal Donasi
                          </th>
                          <th>
                            Jumlah Donasi
                          </th>
                          <th>
                            Status
                          </th>
                          <th>
                            Ket
                          </th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach($datas as $data)
                        <tr>
                          <td class="py-1">
                          <a href="{{route('antrian.show', $data->id)}}"> 
                            {{$data->kode_antrian}}
                          </a>
                          </td>
                         
                          <td>
                            {{$data->dokter->nama_dokter}}
                          </td>
                         
                        
              
                          <td>
                            {{date('d/m/y', strtotime($data->tgl_antrian))}}
                          </td>

                          <td>
                            {{$data->poli}}
                          </td>
              

                          <td>
                          @if($data->status == 'Pasien Baru')
                            <label class="badge badge-warning">Pasien Baru</label>
                          @else
                            <label class="badge badge-success">Pasien Lama</label>
                          @endif
                          </td>

                           <td>
                            {{$data->ket}}
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>
               {{--  {!! $datas->links() !!} --}}
                </div>
              </div>
            </div>
          </div>
          @endif
@endsection