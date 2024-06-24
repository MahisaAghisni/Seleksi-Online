@extends('template.main')
@section('content')
    @include('template.navbar.peserta')

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3" style="min-height: 450px;">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="widget-heading">
                                    <h5 class="">Ujian</h5>
                                </div>
                                <div class="table-responsive" style="overflow-x: scroll;">
                                    <table id="datatable-table" class="table text-center text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Pelatihan</th>
                                                <th>Tanggal Seleksi</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ujian as $u)
                                                <tr>
                                                    <td>
                                                        @if ($u->ujian)
                                                            {{ $u->ujian->nama }}
                                                        @else
                                                            Ujian not found
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($u->ujian)
                                                            {{ $u->ujian->pelatihan->nama_pelatihan }}
                                                        @else
                                                            Ujian not found
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($u->ujian && $u->ujian->seleksi && $u->ujian->seleksi->count() > 0)
                                                            @php
                                                                $firstSeleksi = $u->ujian->seleksi->first();
                                                            @endphp
                                                            @if ($firstSeleksi->tanggal)
                                                                {{ $firstSeleksi->tanggal }} - {{ $firstSeleksi->jam }}
                                                            @else
                                                                Tanggal Tidak Tersedia
                                                            @endif
                                                        @else
                                                            Data Tanggal Tidak Tersedia
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($u->ujian && $u->ujian->pelatihan)
                                                            @php
                                                                $seleksi = \App\Models\Seleksi::where(
                                                                    'idPelatihan',
                                                                    $u->ujian->pelatihan_id,
                                                                )
                                                                    ->where('idUjian', $u->ujian->id)
                                                                    ->where('idGelombang', $u->ujian->gelombang_id)
                                                                    ->first();
                                                            @endphp
                                                            @if ($seleksi && $seleksi->tanggal && $seleksi->jam)
                                                                <a href="{{ url('peserta/ujian/' . $u->kode) }}"
                                                                    data-tanggal="{{ $seleksi->tanggal }}"
                                                                    data-jam="{{ $seleksi->jam }}"
                                                                    class="btn btn-primary btn-sm @if ($u->waktu_berakhir === null) btn-kerjakan @endif">
                                                                    @if ($u->waktu_berakhir == null)
                                                                        <span data-feather="edit-3"></span> kerjakan
                                                                    @endif

                                                                    @if ($u->waktu_berakhir)
                                                                        @if ($u->selesai == null)
                                                                            <span data-feather="edit-3"></span> lanjut
                                                                            kerjakan
                                                                        @else
                                                                            <span data-feather="eye"></span> lihat
                                                                        @endif
                                                                    @endif
                                                                </a>
                                                            @else
                                                                <p>Tanggal dan jam tidak tersedia</p>
                                                            @endif
                                                        @else
                                                            <p>Data ujian atau seleksi tidak tersedia</p>
                                                        @endif

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
        document.addEventListener("DOMContentLoaded", function() {
            const buttons = document.querySelectorAll(".btn-kerjakan");

            buttons.forEach(button => {
                const tanggal = button.getAttribute("data-tanggal");
                const jam = button.getAttribute("data-jam");
                const ujianStartDateTime = new Date(`${tanggal}T${jam}`);
                const ujianEndDateTime = new Date(`${tanggal}T23:59:59`);

                button.addEventListener("click", function(e) {
                    const now = new Date();

                    if (now < ujianStartDateTime) {
                        e.preventDefault();
                        swal({
                            title: "Ujian ini belum dimulai",
                            text: "Silakan coba lagi nanti sesuai jadwal yang telah ditentukan.",
                            type: "warning",
                            button: "OK"
                        });
                    } else if (now > ujianEndDateTime) {
                        e.preventDefault();
                        swal({
                            title: "Waktu ujian telah berakhir",
                            text: "Anda tidak dapat mengerjakan ujian ini karena waktu telah habis.",
                            type: "warning",
                            button: "OK"
                        });
                    } else {
                        e.preventDefault();
                        const t = button.getAttribute("href");
                        swal({
                            title: "yakin mulai ujian?",
                            text: "waktu ujian akan dimulai & tidak bisa berhenti!",
                            type: "warning",
                            showCancelButton: !0,
                            cancelButtonText: "tidak",
                            confirmButtonText: "ya, mulai",
                            padding: "2em"
                        }).then(function(e) {
                            e.value && (document.location.href = t)
                        });
                    }
                });
            });
        });

        $("#datatable-table").DataTable({
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            oLanguage: {
                oPaginate: {
                    sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                sInfo: "Tampilkan halaman _PAGE_ dari _PAGES_",
                sSearch: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                sSearchPlaceholder: "Cari Data...",
                sLengthMenu: "Hasil :  _MENU_"
            },
            stripeClasses: [],
            lengthMenu: [
                [-1, 5, 10, 25, 50],
                ["All", 5, 10, 25, 50]
            ]
        });
    </script>
@endsection
