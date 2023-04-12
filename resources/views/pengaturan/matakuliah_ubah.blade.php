@extends('layouts.master')
@section('title', 'Ubah Mata Kuliah')

@section('css')
@endsection

@section('style')
<style>
</style>
@endsection

@section('breadcrumb-items')
<span class="text-muted fw-light">Pengaturan / Mata Kuliah / </span>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card tour-card">
            <h5 class="card-header">Ubah Mata Kuliah </h5>
            <div class="card-body">
            <form id="formAccountSettings" enctype="multipart/form-data" action="" method="POST">
                    @csrf
                    <div class="row">
                    <div class="mb-3 col-md-12">
                            <label for="kode_mk" class="form-label">Kode Mata Kuliah<i class="text-danger">*</i></label>
                            <input type="text" name="kode_mk" value="{{ $data->kode_mk }}"
                                class="form-control @error('kode_mk') is-invalid @enderror" placeholder="">
                            @error('kode_mk')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                      <div class="mb-3 col-md-12">
                            <label for="mata_kuliah" class="form-label">Mata Kuliah<i class="text-danger">*</i></label>
                            <input type="text" name="mata_kuliah" value="{{ $data->mata_kuliah }}"
                                class="form-control @error('mata_kuliah') is-invalid @enderror" placeholder="">
                            @error('mata_kuliah')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="sks" class="form-label">SKS</label>
                            <input type="text" name="sks" value="{{ $data->sks }}"
                                class="form-control @error('sks') is-invalid @enderror" placeholder="">
                            @error('sks')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mt-2">
                            <button type="submit" name="ubah" class="btn btn-primary me-2">Ubah</button>
                            <a class="btn btn-outline-secondary" href="{{ route('pengaturan.matakuliah') }}">Kembali</a>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
</script>
@endsection