@extends('layouts.master')
@section('title', 'Rekognisi')

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
                            <div class="offset-md-9 col-md-3 text-md-end text-center pt-3 pt-md-0">
                                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#newrecord" aria-controls="offcanvasEnd" tabindex="0"
                                    aria-controls="DataTables_Table_0" type="button"><span><i
                                            class="bx bx-plus me-sm-2"></i>
                                        <span>Tambah Data</span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas offcanvas-end @if($errors->all()) show @endif" tabindex="-1" id="newrecord"
                aria-labelledby="offcanvasEndLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasEndLabel" class="offcanvas-title">Tambah Data</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body my-auto mx-0 flex-grow-1">
                    <form class="add-new-record pt-0 row g-2 fv-plugins-bootstrap5 fv-plugins-framework"
                        enctype="multipart/form-data" id="form-add-new-record" method="POST" action="">
                        @csrf
                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label class="form-label" for="basicDate">Mata Kuliah</label>
                            <div class="input-group input-group-merge has-validation">
                                <select
                                    class="form-select select2-modal col-sm-12 @error('mata_kuliah') is-invalid @enderror"
                                    name="mata_kuliah" data-placeholder="--Silahkan Pilih--">
                                    <option value="" selected disabled>--Silahkan Pilih--</option>
                                    @foreach($mata_kuliah as $x)
                                    <option value="{{ $x->id }}" {{ ($x->id==old('mata_kuliah') ? "selected": "") }}>
                                        {{ $x->mata_kuliah }}</option>
                                    @endforeach
                                </select>
                                @error('mata_kuliah')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 fv-plugins-icon-container">
                            <label class="form-label" for="basicSalary">Bukti Dokumen Rekognisi</label>
                            <div class="input-group input-group-merge has-validation">
                                <input class="form-control @error('dokumen') is-invalid @enderror" name="dokumen"
                                    type="file" accept=".pdf, .doc, .docx" title="Sertakan dokumen ekstensi pdf/doc">
                                @error('dokumen')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 mt-4">
                            <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary"
                                data-bs-dismiss="offcanvas">Cancel</button>
                        </div>
                        <div></div><input type="hidden">
                    </form>

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
                url: "{{ route('rekognisi.data') }}",
                data: function (d) {
                    d.select_dosen = $('#mata_kuliah').val(),
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
                            var html = row.user.nama ;
                            return html;
                        }
                    },
                },
                {
                    render: function (data, type, row, meta) {
                        if (row.mata_kuliah != null) {
                            var x = row.mata_kuliah['mata_kuliah'] ;
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
                        return `<a class="text-success" title="Edit" href="{{ url('rekognisi/ubah/` + row.idd + `') }}"><i class="bx bxs-edit"></i></a>
                            <a class="text-danger" title="Delete" onclick="DeleteId(` + row.id +`)" ><i class="bx bx-trash"></i></a> `;
                    },
                    className: "text-center"
                }

            ]
        });
    });
    $('#mata_kuliah').change(function () {
            table.draw();
    });

    function DeleteId(id) {
        swal({
                title: "Anda yakin?",
                text: "Setelah dihapus, data tidak dapat dipulihkan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "{{ route('rekognisi.hapus') }}",
                        type: "DELETE",
                        data: {
                            "id": id,
                            "_token": $("meta[name='csrf-token']").attr("content"),
                        },
                        success: function (data) {
                            if (data['success']) {
                                swal(data['message'], {
                                    icon: "success",
                                });
                                $('#datatable').DataTable().ajax.reload();
                            } else {
                                swal(data['message'], {
                                    icon: "error",
                                });
                            }
                        }
                    })
                }
            })
    }


</script>
@endsection
