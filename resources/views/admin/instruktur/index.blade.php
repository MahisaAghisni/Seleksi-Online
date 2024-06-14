@extends('template.main')
@section('content')
    @include('template.navbar.admin')
    <style>
        .table-responsive::-webkit-scrollbar {
            background-color: transparent;
            width: 0px;
        }

        .table-responsive:hover::-webkit-scrollbar {
            width: 8px;
        }

        .table-responsive:hover::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, .2)
        }

        @media (hover: none) {
            .table-responsive::-webkit-scrollbar {
                width: 8px;
            }

            .table-responsive::-webkit-scrollbar-thumb {
                background-color: rgba(0, 0, 0, .2)
            }
        }
    </style>

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3" style="min-height: 450px;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="widget-heading">
                                    <h5 class="">Instruktur</h5>
                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm mt-3" data-toggle="modal"
                                        data-target="#tambah_instruktur">
                                        <i data-feather="user-plus"></i> Tambah
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-success btn-sm mt-3" data-toggle="modal"
                                        data-target="#import_instruktur">
                                        <i data-feather="file-text"></i> Impor Excel
                                    </a>
                                    {{-- <a href="{{ url('/admin/ekspor_instruktur') }}" class="btn btn-warning btn-sm mt-3"
                                        target="_blank">
                                        <i data-feather="file-text"></i> Ekspor Excel
                                    </a> --}}
                                </div>
                                <div class="table-responsive p-2 mt-3">
                                    <table id="datatable-table" class="table text-center text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            @foreach ($instruktur->sortBy('id') as $ins)
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= $ins->nama_instruktur ?></td>
                                                    <td><?= $ins->email ?></td>
                                                    <td>
                                                        <a href="javascript:void(0)" data-toggle="modal"
                                                            data-target="#edit_instruktur"
                                                            data-instruktur="{{ $ins->id }}"
                                                            class="btn btn-primary btn-sm edit-instruktur">
                                                            <i data-feather="edit"></i>
                                                        </a>
                                                        <a href="{{ url('/admin/hapus_instruktur') }}/{{ $ins->id }}"
                                                            class="btn btn-danger btn-sm btn-hapus">
                                                            <i data-feather="x-circle"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- <div class="col-lg-5 d-flex">
                                <img src="{{ url('assets/img') }}/teacher.svg" class="align-center" alt=""
                                    style="width: 100%;">
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('template.footer')
    </div>
    <!--  END CONTENT AREA  -->

    <!-- MODAL -->
    <!-- Modal Tambah -->
    <div class="modal fade" id="tambah_instruktur" tabindex="-1" role="dialog" aria-labelledby="tambah_instrukturLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ url('/admin/tambah_instruktur') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambah_instrukturLabel">Tambah Instruktur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            x
                        </button>
                    </div>
                    <div class="modal-body">
                        <a href="javascript:void(0)" class="btn btn-success mb-3 tambah-baris-instruktur">tambah baris</a>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Gender</th>
                                    <th>Email</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-instruktur">
                                <tr>
                                    <td>
                                        <input type="text" name="nama_instruktur[]" required
                                            style="border: none; background: transparent; width: 100%; height: 100%;">
                                    </td>
                                    <td>
                                        <select name="gender[]" required
                                            style="border: none; background: transparent; width: 100%; height: 100%;">
                                            <option value="">pilih</option>
                                            <option value="Laki - Laki">Laki - Laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="email[]" required
                                            style="border: none; background: transparent; width: 100%; height: 100%;">
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" value="reset" class="btn" data-dismiss="modal"><i
                                class="flaticon-cancel-12"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal edit -->
    <div class="modal fade" id="edit_instruktur" tabindex="-1" role="dialog" aria-labelledby="edit_instrukturLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ url('/admin/edit_instruktur') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit_instrukturLabel">Edit Instruktur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            x
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Nama Instruktur</label>
                            <input type="hidden" name="id" id="id_instruktur" value="{{ old('id') }}"
                                class="form-control">
                            <input type="text" name="nama_instruktur" id="nama_instruktur"
                                value="{{ old('nama_instruktur') }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">Gender</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="Laki - Laki">Laki - Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="form-control" required>
                            @error('email')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Active</label>
                            <select name="is_active" id="active" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" value="reset" class="btn" data-dismiss="modal"><i
                                class="flaticon-cancel-12"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="import_instruktur" tabindex="-1" role="dialog"
        aria-labelledby="import_instrukturLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ url('/admin/impor_instruktur') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="import_instrukturLabel">Import Instruktur Excel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            x
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Download Template</label>
                            <br>
                            <a href="{{ url('/admin/impor_instruktur') }}" target="_blank" class="btn btn-primary">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                    stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                    class="css-i6dzq1">
                                    <polyline points="8 17 12 21 16 17"></polyline>
                                    <line x1="12" y1="12" x2="12" y2="21"></line>
                                    <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="form-group">
                            <label for="">File Excel</label>
                            <div class="custom-file mb-4">
                                <input type="file" name="file" class="custom-file-input" id="customFile"
                                    accept=".xls, .xlsx">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <p><br>note : jangan ubah bagian header di file excel</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" value="reset" class="btn" data-dismiss="modal"><i
                                class="flaticon-cancel-12"></i> Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END MODAL -->

    {!! session('pesan') !!}
    <script>
        $(document).ready(function() {
            // INSTRUKTUR
            $('.tambah-baris-instruktur').click(function() {
                const instruktur = `
                    <tr>
                        <td><input type="text" name="nama_instruktur[]" required style="border: none; background: transparent; width: 100%; height: 100%;"></td>
                        <td>
                            <select name="gender[]" required style="border: none; background: transparent; width: 100%; height: 100%;">
                                <option value="">pilih</option>
                                <option value="Laki - Laki">Laki - Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </td>
                        <td><input type="text" name="email[]" required style="border: none; background: transparent; width: 100%; height: 100%;"></td>
                        <td>
                            <button class="btn btn-danger">
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                            </button>
                        </td>
                    </tr>
                `;
                $('#tbody-instruktur').append(instruktur)
            });
            $("#datatable-table").DataTable({
                scrollY: "300px",
                scrollX: !0,
                scrollCollapse: !0,
                paging: !0,
                oLanguage: {
                    oPaginate: {
                        sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    sInfo: "tampilkan halaman _PAGE_ dari _PAGES_",
                    sSearch: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    sSearchPlaceholder: "Cari Data...",
                    sLengthMenu: "Hasil :  _MENU_"
                },
                stripeClasses: [],
                lengthMenu: [
                    [-1, 5, 10, 25, 50],
                    ["All", 5, 10, 25, 50]
                ]
            }), $("#tbody-instruktur").on("click", "tr td button", function() {
                $(this).parents("tr").remove()
            }), $(".edit-instruktur").click(function() {
                var e = $(this).data("instruktur");
                $.ajax({
                    type: "get",
                    data: {
                        id_instruktur: e
                    },
                    dataType: "json",
                    async: !0,
                    url: "{{ route('ajaxinstruktur') }}",
                    success: function(e) {
                        $("#id_instruktur").val(e.id), $("#nama_instruktur").val(e
                                .nama_instruktur), $("#gender")
                            .val(e.gender), $("#email").val(e.email), $("#active").val(e
                                .is_active)
                    }
                })
            }), $(".btn-hapus").on("click", function(e) {
                e.preventDefault();
                var t = $(this).attr("href");
                swal({
                    title: "yakin di hapus?",
                    text: "data yang berkaitan dengan data instruktur ini juga akan di hapus!",
                    type: "warning",
                    showCancelButton: !0,
                    cancelButtonText: "tidak",
                    confirmButtonText: "ya, hapus",
                    padding: "2em"
                }).then(function(e) {
                    e.value && (document.location.href = t)
                })
            }), $(".custom-file-input").on("change", function() {
                var e = $(this).val().split("\\").pop();
                $(this).next(".custom-file-label").addClass("selected").html(e)
            });
        })
    </script>
    @if (old('email'))
        <script>
            $('#edit_instruktur').modal('show');
            $("#id_instruktur").val("{{ old('id') }}");
            $("#gender").val("{{ old('gender') }}");
            $("#active").val("{{ old('is_active') }}");
        </script>
    @endif
@endsection
