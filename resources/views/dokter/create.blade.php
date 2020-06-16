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

<form method="POST" action="{{ route('dokter.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
<div class="row">
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Tambah dokter baru</h4>
                      
                        <div class="form-group{{ $errors->has('nama_acr') ? ' has-error' : '' }}">
                            <label for="nama_acr" class="col-md-4 control-label">dokter</label>
                            <div class="col-md-6">
                                <input id="nama_acr" type="text" class="form-control" name="nama_acr" value="{{ old('nama_acr') }}" required>
                                @if ($errors->has('nama_acr'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nama_acr') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('tgl_dokter') ? ' has-error' : '' }}">
                            <label for="tgl_dokter" class="col-md-4 control-label">Tanggal</label>
                            <div class="col-md-6">
                                <input id="tgl_dokter" type="date" class="form-control" name="tgl_dokter" value="{{ old('tgl_dokter') }}" required>
                                @if ($errors->has('tgl_dokter'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tgl_dokter') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                
                        <div class="form-group{{ $errors->has('jumlah_dokter') ? ' has-error' : '' }}">
                            <label for="jumlah_dokter" class="col-md-4 control-label">Jumlah dokter</label>
                            <div class="col-md-6">
                                <input id="jumlah_dokter" type="number" maxlength="4" class="form-control" name="jumlah_dokter" value="{{ old('jumlah_dokter') }}" required>
                                @if ($errors->has('jumlah_dokter'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('jumlah_dokter') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('ket') ? ' has-error' : '' }}">
                            <label for="ket" class="col-md-4 control-label">ket</label>
                            <div class="col-md-12">
                                <input id="ket" type="text" class="form-control" name="ket" value="{{ old('ket') }}" >
                                @if ($errors->has('ket'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ket') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">Cover</label>
                            <div class="col-md-6">
                                <img width="200" height="200" />
                                <input type="file" class="uploads form-control" style="margin-top: 20px;" name="cover">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="submit">
                                    Submit
                        </button>
                        <button type="reset" class="btn btn-danger">
                                    Reset
                        </button>
                        <a href="{{route('dokter.index')}}" class="btn btn-light pull-right">Back</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

</div>
</form>
@endsection