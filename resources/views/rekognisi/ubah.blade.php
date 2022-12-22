@extends('layouts.master')
@section('title', 'Ubah Data')

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('style')
<style>
</style>
@endsection

@section('breadcrumb-items')
<span class="text-muted fw-light">Rekognisi / </span>
@endsection


@section('content')
<div class="card">
    <div class="card-datatable table-responsive">
        <h5 class="card-header">Ubah Data Rekognisi</h5>
        <div class="card-body">
            <form id="formAccountSettings" enctype="multipart/form-data" action="" method="POST">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="mata_kuliah" class="form-label">Mata Kuliah <i class="text-danger">*</i></label>
                        <select class="form-select select2 col-sm-12 @error('mata_kuliah') is-invalid @enderror"
                            name="mata_kuliah">
                            <option value="" selected disabled>--Silahkan Pilih--</option>
                            @foreach($mata_kuliah as $x)
                            <option value="{{ $x->id }}" {{ ($x->id==$data->id_mk ? "selected": "") }}>
                                {{ $x->mata_kuliah }}</option>
                            @endforeach
                        </select>
                        @error('mata_kuliah')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="link" class="form-label">Dokumen</label>
                        <input class="form-control @error('dokumen') is-invalid @enderror" name="dokumen" type="file"
                            accept=".pdf, .doc, .docx"
                            title="Silahkan unggah kembali, jika ada perubahan dokumen. (ekstensi pdf/doc)">
                        @error('dokumen')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <button type="submit" name="ubah" class="btn btn-primary me-2">Ubah</button>
                        <a class="btn btn-outline-secondary" href="{{ url()->previous() }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@section('script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script>
    "use strict";
    setTimeout(function () {
        (function ($) {
            "use strict";
            $(".select2").select2({
                minimumResultsForSearch: 5
            });
        })(jQuery);
    }, 350);

</script>
@endsection
