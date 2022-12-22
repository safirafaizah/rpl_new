@extends('layouts.master')
@section('title', 'Verifikasi / '.$data->user->nama)

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('style')
<style>
    td {
        vertical-align: top;
        word-wrap: break-word;
    }

</style>
@endsection

@section('breadcrumb-items')
<span class="text-muted fw-light">Rekognisi / </span>
@endsection


@section('content')
@foreach ($errors->all() as $error)
<div class="alert alert-danger alert-dismissible" role="alert">
    {{ $error }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endforeach

<div class="row invoice-preview">
    <!-- Details Data -->
    <div class="col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
        <div class="card invoice-preview-card">
            <div class="card-body">
                <div class="row">
                    <div class="mb-xl-0 mb-4 col-md-7">
                        <div class="d-flex svg-illustration mb-3 gap-2">
                            <span class="app-brand-logo demo">
                                <img src="{{ $data->user->image() }}"
                                    class="d-block h-auto ms-0 rounded user-profile-img" width="100px">
                            </span>
                        </div>
                        <h3 class="mb-1">{{ $data->user->nama }}</h3>
                    </div>
                    <div class=" col-md-5">
                        <div class="mb-2">
                            <span class="me-1"><i class='bx bx-mail-send'></i> {{ $data->user->email }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="me-1"><i class='bx bx-briefcase'></i> {{ $data->user->jabatan }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-0">
            <div class="card-body">
                <div class="row p-0">
                    <div class="">
                        <h6 class="pb-2">Verifikasi Rekognisi
                        </h6>
                        <table class="" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td class="pe-3 text-muted w-30" style="width: 130px;">Mata Kuliah</td>
                                    <td class="w-70">
                                        {{ ($data->mata_kuliah == null ? "-": $data->mata_kuliah->mata_kuliah) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pe-3 text-muted w-30">Dokumen</td>
                                    <td class="w-70" style="max-width: 110px;">
                                        <a href="{{ asset('').$data->dokumen }}"
                                            target="_blank">{{ $data->dokumen }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pe-3 text-muted w-30">Status</td>
                                    <td class="w-70 text-{{$data->status->warna}}">
                                        <strong>{{ $data->status->status }}</strong></td>
                                </tr>
                                @if($data->catatan != null)
                                <tr>
                                    <td class="pe-3 text-muted w-30">Catatan</td>
                                    <td class="w-70">{{ $data->catatan }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Details Data -->

    <!-- Actions -->
    <div class="col-xl-3 col-md-4 col-12 invoice-actions">
        <div class="card">
            <div class="card-body text-center">
                <button class="btn btn-success d-grid w-100 mb-3" data-bs-toggle="offcanvas"
                    data-bs-target="#modalDiterima" @if($data->id_status == "V") disabled
                    @endif >
                    <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                            class="bx bx-check bx-xs me-3"></i>Verifikasi</span>
                </button>
                <button class="btn btn-danger d-grid w-100" data-bs-toggle="offcanvas" data-bs-target="#modalDitolak"
                    @if($data->id_status == "V") disabled @endif >
                    <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                            class="bx bx-x bx-xs me-3"></i>Tolak Data</span>
                </button>
            </div>
        </div>
    </div>
    <!-- /Actions -->
</div>

<!-- Offcanvas -->
<!--Diterima Sidebar -->
@if($data->id_status != "V" || $data->id_status == "D")
<div class="offcanvas offcanvas-end" id="modalDiterima" aria-hidden="true">
    <div class="offcanvas-header mb-3">
        <h5 class="offcanvas-title">Verifikasi Data dan Jadwal Assesmen</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form method="POST" action="">
            @csrf
            <div class=" mb-3">
                <label class="form-label">Nama Asesor<i class="text-danger">*</i></label>
                <select class="form-select select2-modal col-sm-12 @error('asesor') is-invalid @enderror"
                    name="asesor" data-placeholder="--Silahkan Pilih--">
                   
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Mulai Assessmen<i class="text-danger">*</i></label>
                <input class="form-control digits" autocomplete="off" type="datetime-local" id="date_start"
                    name="date_start">
                @error('date_start')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Berakhir Assessmen<i class="text-danger">*</i></label>
                <input class="form-control digits" autocomplete="off" type="datetime-local" id="date_end"
                    name="date_end">
                @error('date_end')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class=" mb-3">
                <label class="form-label">Ruangan<i class="text-danger">*</i></label>
                <select class="form-select digits " name="lecturer_id" id="lecturer_id" data-placeholder="Select">
                    <option value="" selected disabled>--Silahkan Pilih--</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan<i class="text-danger">*</i></label>
                <input type="text" name="keterangan" id="data" placeholder="Keterangan" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea class="form-control" name="catatan" cols="3" rows="8"
                    placeholder="Boleh dikosongkan.."></textarea>
            </div>

            <div class="mb-3 d-flex flex-wrap">
                <input type="hidden" name="action" value="verifikasi">
                <button type="submit" class="btn btn-success me-3" data-bs-dismiss="offcanvas">Verifikasi</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>


        </form>
    </div>
</div>
@endif
<!-- /Sidebar -->

<!-- Ditolak Sidebar -->
<div class="offcanvas offcanvas-end" id="modalDitolak" aria-hidden="true">
    <div class="offcanvas-header mb-3">
        <h5 class="offcanvas-title">Tolak Data</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow-1">
        <form method="POST" action="">
            @csrf
            <div class="mb-3">
                <label class="form-label">Catatan <i class="text-danger">*</i></label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" cols="3"
                    rows="8"></textarea>
                @error('catatan')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-4">
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="kirim_email" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Kirim Notifikasi Email ke Dosen</label>
                </div>
            </div>
            <div class="mb-3 d-flex flex-wrap">
                <input type="hidden" name="action" value="tolak">
                <button type="submit" class="btn btn-danger me-3" data-bs-dismiss="offcanvas">Tolak</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>
<!-- /Sidebar -->
<!-- /Offcanvas -->

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
<script>
    $(document).ready(function () {
        const selectElement = document.querySelector('#flexSwitchCheckDefault');
        selectElement.addEventListener('change', (event) => {
            selectElement.value = selectElement.checked ? 1 : 0;
            // alert(selectElement.value);
        });
    });

</script>
@endsection
