@extends('template.main')
@section('content')
    @include('template.navbar.instruktur')

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3" style="min-height: 500px;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="widget-heading">
                                    <h5 class="">Ujian </h5>
                                    @if ($ujianActive >= 1)
                                        <form action="{{ url('/instruktur/edit_ujian/1?is_active=0') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary mt-3 btn-addData">
                                                Tambah
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ url('/instruktur/ujian/create') }}"
                                            class="btn btn-primary mt-3">Tambah</a>
                                    @endif
                                </div>
                                <div class="table-responsive mt-3" style="overflow-x: scroll;">
                                    <table id="datatable-table" class="table text-center text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Pelatihan</th>
                                                <th>Status</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ujian as $u)
                                                <tr>
                                                    <td>{{ $u->nama }}</td>
                                                    <td>{{ $u->pelatihan->nama_pelatihan }}</td>
                                                    <td>{{ $u->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                                                    <td class="d-flex justify-content-center">
                                                        @if ($u->jenis == 0)
                                                            <a href="{{ url('/instruktur/ujian/' . $u->kode) }}"
                                                                class="btn btn-sm"
                                                                style="background-color: #5BBCFF;color:white">
                                                                <span data-feather="eye"></span>
                                                            </a>
                                                        @endif
                                                        @if ($u->is_active)
                                                            <form
                                                                action="{{ url('/instruktur/edit_ujian/' . $u->id . '?is_active=0') }}"
                                                                method="POST">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-warning btn-sm btn-uncheck">
                                                                    <span data-feather="x"></span>
                                                                </button>
                                                            </form>
                                                        @else
                                                            @if ($ujianActive >= 1)
                                                                <form
                                                                    action="{{ url('/instruktur/edit_ujian/' . $u->id . '?is_active=1') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-warning btn-sm btn-activated">
                                                                        <span data-feather="check"></span>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <form
                                                                    action="{{ url('/instruktur/edit_ujian/' . $u->id . '?is_active=1') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-warning btn-sm btn-check">
                                                                        <span data-feather="check"></span>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        @endif
                                                        @if ($u->jenis == 1)
                                                            <a href="{{ url('/instruktur/ujian_essay/' . $u->kode) }}"
                                                                class="btn btn-info btn-sm" style="background: #5BBCFF">
                                                                <span data-feather="eye"></span>
                                                            </a>
                                                        @endif
                                                        <form action="{{ url('/instruktur/ujian/' . $u->kode) }}"
                                                            method="post" class="d-inline" id="formHapus">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm btn-hapus">
                                                                <span data-feather="trash"></span>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('template.footer')
    </div>
    <!--  END CONTENT AREA  -->

    <script>
        $(document).ready(function() {
            $(".btn-hapus").on("click", function(e) {
                var t = $(this);
                e.preventDefault(), swal({
                    title: "yakin di hapus?",
                    text: "data yang berkaitan akan dihapus dan tidak bisa di kembalikan!",
                    type: "warning",
                    showCancelButton: !0,
                    cancelButtonText: "tidak",
                    confirmButtonText: "ya, hapus",
                    padding: "2em"
                }).then(function(e) {
                    e.value && t.parent("form").submit()
                })
            }), $("#datatable-table").DataTable({
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
            }), $(".btn-check").on("click", function(e) {
                var t = $(this);
                e.preventDefault(), swal({
                    title: "yakin di aktifkan?",
                    text: "ujian akan di aktifkan dan bisa di akses oleh peserta!",
                    type: "warning",
                    showCancelButton: !0,
                    cancelButtonText: "tidak",
                    confirmButtonText: "ya, aktifkan",
                    padding: "2em"
                }).then(function(e) {
                    e.value && t.parent("form").submit()
                })
            }), $(".btn-uncheck").on("click", function(e) {
                var t = $(this);
                e.preventDefault(), swal({
                    title: "yakin di nonaktifkan?",
                    text: "ujian akan di nonaktifkan dan tidak bisa di akses oleh peserta!",
                    type: "warning",
                    showCancelButton: !0,
                    cancelButtonText: "tidak",
                    confirmButtonText: "ya, nonaktifkan",
                    padding: "2em"
                }).then(function(e) {
                    e.value && t.parent("form").submit()
                })
            }), $(".btn-addData").on("click", function(e) {
                var t = $(this);
                e.preventDefault(), swal({
                    title: "Anda tidak bisa menambahkan Data",
                    text: "Data ujian aktif sudah ada, mohon nonaktifkan terlebih dahulu!",
                    type: "warning",

                    padding: "2em"
                })
            })
        }), $(".btn-activated").on("click", function(e) {
            var t = $(this);
            e.preventDefault(), swal({
                title: "Anda tidak bisa mengaktifkan ujian ini",
                text: "Data ujian aktif sudah ada, mohon nonaktifkan terlebih dahulu!",
                type: "warning",

                padding: "2em"
            })

        });
    </script>

    {!! session('pesan') !!}
@endsection
