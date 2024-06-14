@extends('template.main')
@section('content')
@include('template.navbar.admin')

<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-lg-12 layout-spacing">
                <div class="widget shadow p-3">
                    <form action="{{ url('/admin/peserta') }}" method="POST">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-4 col-lg-3">
                                <div class="">
                                    <label for="exampleFormControlInput1" class="form-label">Gelombang</label>
                                    <select name="idGelombang" id="exampleFormControlInput1"
                                        class="form-control js-example-basic-single" required
                                        onchange="handleReqGelombang(this)">
                                        <option value="" selected>Pilih Gelombang</option>
                                        @foreach ($gelombang->sortByDesc('id') as $gel)
                                        <option value="{{ $gel->id }}">
                                            {{ $gel->tahun }}-{{ $gel->gelombang }}-{{ $gel->anggaran->nama_anggaran ?? '-' }}-{{ $gel->jenisPelatihan->pelatihan ?? '-' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 col-lg-3">
                                <div class="">
                                    <label for="exampleFormControlInput2" class="form-label">Pelatihan</label>
                                    <select name="pelatihan" id="exampleFormControlInput2"
                                        class="form-control js-example-basic-single" required>
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive mt-4">
                                <table id="datatable-table" class="table text-center text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama Peserta</th>
                                            <th>Tanggal Lahir</th>
                                            <th>No Hp</th>
                                            <th>Pelatihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                            ?>
                                        @if (!empty($idGelombang) && !empty($pelatihan))
                                        @foreach ($peserta as $p)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $p->ktp }}</td>
                                            <td>{{ $p->firstname }}</td>
                                            <td>{{ $p->birthdate }}</td>
                                            <td>{{ $p->hp }}</td>
                                            <td>
                                                @if ($p->pelatihans)
                                                {{ $p->pelatihans->nama_pelatihan }}
                                                @else
                                                -
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="7" class="text-center">Silakan pilih gelombang dan
                                                pelatihan untuk menampilkan data.</td>
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
</script>
@endsection
