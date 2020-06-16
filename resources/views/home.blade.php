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
    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-poll-box text-danger icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right">Antrian</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">{{$antrian->count()}}</h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Total seluruh Antrian
                  </p>
                </div>
              </div>
            </div>
            @if(Auth::user()->level == 'admin')
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-receipt text-warning icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right">Proses Pasien Baru</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">{{$antrian->where('status', 'Pasien Lama')->count()}}</h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> Sedang diproses
                  </p>
                </div>
              </div>
            </div>
            @endif

            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-book text-success icon-lg" style="width: 40px;height: 40px;"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right">Dokter</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">{{$dokter->count()}}</h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-book mr-1" aria-hidden="true"></i> Total seluruh dokter
                  </p>
                </div>
              </div>
            </div>
            
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="mdi mdi-account-location text-info icon-lg"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right">Pasien</p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">{{$pasien->count()}}</h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                    <i class="mdi mdi-account mr-1" aria-hidden="true"></i> Total seluruh pasien
                  </p>
                </div>
              </div>
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