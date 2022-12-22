@extends('layouts.master')
@section('title', 'Verifikasi Rekognisi')

@section('breadcrumb-items')
<!-- <span class="text-muted fw-light">Pusat Data /</span> -->
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/sweetalert2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
@endsection

@section('style')
<style>
    table.dataTable tbody td {
        vertical-align: middle;
    }

    table.dataTable td:nth-child(2) {
        max-width: 200px;
    }

    table.dataTable td:nth-child(3) {
        max-width: 150px;
    }

    table.dataTable td:nth-child(4) {
        max-width: 50px;
    }

    table.dataTable td:nth-child(5) {
        max-width: 50px;
    }

    table.dataTable td:nth-child(6) {
        max-width: 50px;
    }

    table.dataTable td {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        word-wrap: break-word;
    }

</style>
@endsection


@section('content')
@if(session('msg'))
<div class="alert alert-primary alert-dismissible" role="alert">
    {{session('msg')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-datatable table-responsive">
        <div class="card-header flex-column flex-md-row pb-0">
            <div class="row">
                <div class="col-12 pt-3 pt-md-0">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-3">
                                <select id="select_mahasiswa" class="select2 form-select" data-placeholder="Mahasiswa">
                                    <option value="">Mahasiswa</option>
                                    @foreach($mahasiswa as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="select_mk" class="select2 form-select" data-placeholder="Mata Kuliah">
                                    <option value="">Mata Kuliah</option>
                                    @foreach($mata_kuliah as $d)
                                    <option value="{{ $d->id }}">{{ $d->mata_kuliah }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="select_status" class="select2 form-select" data-placeholder="Status">
                                    <option value="">Status</option>
                                    @foreach($status as $d)
                                    <option value="{{ $d->id }}">{{ $d->status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-hover table-sm" id="datatable" width="100%">
            <thead>
                <tr>
                    <th width="20px" data-priority="1">No</th>
                    <th data-priority="2">Nama</th>
                    <th>Mata Kuliah</th>
                    <th>Dokumen Rekognisi</th>
                    <th>Status</th>
                    <th width="85px" data-priority="3">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/vendor/libs/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.responsive.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/responsive.bootstrap5.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables.checkboxes.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/datatables-buttons.js')}}"></script>
<script src="{{asset('assets/vendor/libs/datatables/buttons.bootstrap5.js')}}"></script>
<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script>
    "use strict";
    setTimeout(function () {
        (function ($) {
            "use strict";
            $(".select2").select2({
                allowClear: true,
                minimumResultsForSearch: 7
            });
        })(jQuery);
    }, 350);
    setTimeout(function () {
        (function ($) {
            "use strict";
            $(".select2-modal").select2({
                dropdownParent: $('#newrecord'),
                allowClear: true,
                minimumResultsForSearch: 5
            });
        })(jQuery);
    }, 350);

</script>
<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#datatable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ordering: false,
            language: {
                searchPlaceholder: 'Cari..',
                url: "{{asset('assets/vendor/libs/datatables/id.json')}}"
            },
            ajax: {
                url: "{{ route('verifikasi.data') }}",
                data: function (d) {
                    d.select_mahasiswa = $('#select_mahasiswa').val(),
                        d.select_mk = $('#select_mk').val(),
                        d.select_status = $('#select_status').val(),
                        d.search = $('input[type="search"]').val()
                },
            },
            columnDefs: [{
                "defaultContent": "-",
                "targets": "_all"
            }],
            columns: [{
                    render: function (data, type, row, meta) {
                        var no = (meta.row + meta.settings._iDisplayStart + 1);
                        return no;
                    },
                    className: "text-center"
                },
                {
                    render: function (data, type, row, meta) {
                        if (row.user != null) {
                            var html = row.user.nama;
                            return html;
                        }
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        if (row.mata_kuliah != null) {
                            var x = row.mata_kuliah['mata_kuliah'];
                            return x;;
                        }
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        if (row.dokumen != null) {
                            return `<a class="px-2" target="_blank" href="{{ asset('') }}` +
                                row.dokumen + `"><i class="bx bx-file"></i></a>`
                        }
                    },
                    className: "text-md-center"
                },
                {
                    render: function (data, type, row, meta) {
                        if (row.status != null) {
                            var x = '<span class="text-' + row.status['warna'] + '">' + row
                                .status['status'] + '</span>';
                            return x;;
                        }
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        return `<a class="text-primary" title="Lihat" href="{{ url('verifikasi/` +
                            row.idd + `') }}"><i class="bx bxs-show"></i></a>`;
                    },
                    className: "text-center"
                }

            ]
        });

        $('#select_mahasiswa').change(function () {
            table.draw();
        });
        $('#select_mk').change(function () {
            table.draw();
        });
        $('#select_status').change(function () {
            table.draw();
        });

    });

</script>
@endsection
