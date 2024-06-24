@extends('template.main')
@section('content')
    @include('template.navbar.admin')


    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="widget-heading">
                                    <h5 class="">Gelombang</h5>
                                </div>
                                <form action="{{ url('/admin/gelombang') }}" method="POST">
                                    @csrf
                                    <div class="row align-items-end">
                                        <div class="col-4 col-lg-3">
                                            <div class="">
                                                <select name="idGelombang" id="exampleFormControlInput1"
                                                    class="form-control js-example-basic-single" required>
                                                    <option value="" selected>Pilih Gelombang</option>
                                                    @foreach ($dataGelombang->sortByDesc('id') as $gel)
                                                        <option value="{{ $gel->id }}">
                                                            {{ $gel->tahun }}-{{ $gel->gelombang }}-{{ $gel->anggaran->nama_anggaran ?? '-' }}-{{ $gel->jenisPelatihan->pelatihan ?? '-' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2 align-bottom">
                                            <div class="">
                                                <button type="submit" class="btn btn-primary">Cari</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="table-responsive mt-3">
                                    <table id="datatable-table" class="table text-center text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Gelombang</th>
                                                <th>Pelatihan</th>
                                                <th>Jumlah Peserta</th>
                                                <th>Tanggal Seleksi</th>
                                                <th>Soal</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1;
                                            ?>
                                            @if (!empty($idGelombang))
                                                @foreach ($gelombang as $g)
                                                    <tr>
                                                        <td>{{ $no++ }} </td>
                                                        <td>{{ $g->gelombang->tahun }}-{{ $g->gelombang->gelombang }}-{{ $g->gelombang->anggaran->nama_anggaran ?? '-' }}-{{ $g->gelombang->jenisPelatihan->pelatihan ?? '-' }}
                                                        <td>{{ $g->pelatihans->nama_pelatihan ?? '-' }} </td>
                                                        <td>{{ $g->jumlah_peserta }} </td>
                                                        <td>
                                                            @if ($g->dataSeleksi->tanggal && $g->dataSeleksi->jam)
                                                                {{ $g->dataSeleksi->tanggal }} -
                                                                {{ date('H:i', strtotime($g->dataSeleksi->jam)) }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($g->ujian_aktif)
                                                                {{ $g->ujian_aktif->nama }}
                                                            @else
                                                                -
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)" data-toggle="modal"
                                                                data-target="#edit_instruktur"
                                                                data-id="{{ $g->id }}"
                                                                class="btn btn-primary btn-sm edit-instruktur">
                                                                <i data-feather="edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">Silakan pilih gelombang untuk
                                                        menampilkan data.</td>
                                                </tr>
                                            @endif
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

        <div class="modal fade" id="edit_instruktur" tabindex="-1" role="dialog" aria-labelledby="edit_instrukturLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ url('/admin/edit_gelombang') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit_instrukturLabel">Edit Seleksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                x
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="hidden" name="id" id="id_gelombang" value="{{ old('id') }}"
                                    class="form-control">
                                <div class="row">
                                    <div class="col-6">
                                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-6">
                                        <input type="time" name="jam" id="jam" value="{{ old('jam') }}"
                                            class="form-control" required>
                                    </div>
                                </div>
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
    </div>
    <!--  END CONTENT AREA  -->

    {!! session('pesan') !!}
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            $("#datatable-table").DataTable({
                scrollY: "450px",
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
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ]
            });
        })

        function handleReqGelombang(selectElement) {
            var selectedValue = selectElement.value;

            if (selectedValue === '') { // Jika opsi "Pilih Gelombang" dipilih
                $('#exampleFormControlInput2').html('');
                return;
            }

            $.ajax({
                url: '/filter/gelombang/' + selectedValue,
                type: 'GET',
                success: function(response) {
                    var selectOptions = '';
                    console.log(response);
                    if (response.length > 0) {
                        response.forEach(item => {
                            console.log(item);
                            var pelatihan = item.pelatihans ? item.pelatihans.nama_pelatihan : '-';
                            selectOptions += '<option value="' + item.idPelatihan + '">' +
                                pelatihan +
                                '</option>';

                        });
                        $('#exampleFormControlInput2').html(selectOptions);
                    } else {
                        console.log('Data kosong');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your ajax request:', error);
                }
            });
        }

        $('.edit-instruktur').on('click', function() {
            var id = $(this).data('id');
            // var tanggal = $(this).data('tanggal');
            // var jam = $(this).data('jam');
            $('#id_gelombang').val(id);
            // $('#tanggal').val(tanggal);
            // $('#jam').val(jam);
        });
    </script>
@endsection
