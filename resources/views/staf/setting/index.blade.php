@extends('staf.layout.main')
@section('staf')

<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            @if(session()->has('berhasil_update'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Berhasil Update!</strong> Setting Diupdate
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Pengaturan Indikator Aplikasi
                </h5>
                <form action="/update.setting" method="post">
                    @csrf
                    @foreach( $settings as $setting)
                    <div class="form-group">
                        <label for="exampleInputEmail1">Minimal Belanja Crew</label>
                        <input type="text" class="form-control" name="belanja" aria-describedby="emailHelp" value="{{$setting->belanja}}">
                        <small id="emailHelp" class="form-text text-muted">* Minimal belanja crew digunakan sebagai acuan apakah presensi masuk dalam klasifikasi presensi crew atau presensi kartu</small><br>
                        <small id="emailHelp" class="form-text text-danger">* Masukan angka saja tanpa titik/koma</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Minimal Presensi Crew</label>
                        <input type="text" class="form-control" name="min_presensi" aria-describedby="emailHelp" value="{{$setting->min_presensi}}">
                        <small id="emailHelp" class="form-text text-muted">* Minimal presensi crew digunakan sebagai acuan klaim presensi crew</small><br>
                        <small id="emailHelp" class="form-text text-danger">* Masukan angka saja tanpa titik/koma</small>
                    </div>

                    @endforeach
                    <input type="hidden" name="id" value="{{$setting->id}}">
                    <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection