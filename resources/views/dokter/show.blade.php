@section('js')

<script type="text/javascript">

$(document).ready(function() {
    $(".users").select2();
});

</script>

<script type="text/javascript">
        function readURL() {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(input).prev().attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(function () {
            $(".uploads").change(readURL)
            $("#f").submit(function(){
                // do ajax submit or just classic form submit
              //  alert("fake subminting")
                return false
            })
        })
        </script>
@stop

@extends('layouts.app')

@section('content')

<div class="row">
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Detail <b>{{$data->nama_dokter}}</b> </h4>
                      <form class="forms-sample">

                        <div class="form-group">
                            <div class="col-md-6">
                                <img width="200" height="200" @if($data->cover) src="{{ asset('images/dokter/'.$data->cover) }}" @endif />
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nama_dokter') ? ' has-error' : '' }}">
                            <label for="nama_dokter" class="col-md-4 control-label">nama_dokter</label>
                            <div class="col-md-6">
                                <input id="nama_dokter" type="text" class="form-control" name="nama_dokter" value="{{ $data->nama_dokter }}" readonly="">
                                @if ($errors->has('nama_dokter'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_dokter') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                     
                      
                        <div class="form-group{{ $errors->has('jumlah_dokter') ? ' has-error' : '' }}">
                            <label for="jumlah_dokter" class="col-md-4 control-label">Jumlah Dokter</label>
                            <div class="col-md-6">
                                <input id="jumlah_dokter" type="text" class="form-control" name="jumlah_dokter" value="{{ $data->jumlah_dokter }}" readonly>
                                @if ($errors->has('jumlah_dokter'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('jumlah_dokter') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <div class="form-group{{ $errors->has('poli') ? ' has-error' : '' }}">
                            <label for="poli" class="col-md-4 control-label">Poli</label>
                            <div class="col-md-6">
                                <input id="poli" type="text" class="form-control" name="poli" value="{{ $data->poli }}" readonly>
                                @if ($errors->has('poli'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('poli') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       <div class="form-group{{ $errors->has('ket') ? ' has-error' : '' }}">
                            <label for="ket" class="col-md-4 control-label">Keterangan</label>
                            <div class="col-md-6">
                                <input id="ket" type="text" class="form-control" name="ket" value="{{ $data->ket }}" readonly>
                                @if ($errors->has('ket'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ket') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <a href="{{route('dokter.index')}}" class="btn btn-light pull-right">Back</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

</div>
@endsection