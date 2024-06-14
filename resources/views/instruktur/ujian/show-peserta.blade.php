@extends('template.main')
@section('content')
    @include('template.navbar.instruktur')

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3">
                        <div class="widget-heading">
                            <h6 class="text-center">{{ $ujian->nama }}</h6>
                            Nama Peserta : {{ $peserta->nama_peserta }}
                        </div>
                        <div class="widget-content">
                            <div class="table-responsive mt-2">
                                <table class="table table-bordered text-nowrap">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No Soal</th>
                                            <th>Kunci Jawaban</th>
                                            <th>Jawaban Peserta</th>
                                            <th>Status</th>
                                            <th>Ragu Ragu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ujian_peserta as $up)
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $up->detailujian->jawaban }}</td>
                                                <td>
                                                    {{ $up->jawaban === null ? 'TIDAK DIJAWAB' : $up->jawaban }}
                                                </td>
                                                <td>
                                                    @if ($up->benar === null)
                                                        TIDAK DIJAWAB
                                                    @endif
                                                    @if ($up->benar == '1')
                                                        BENAR
                                                    @endif
                                                    @if ($up->benar == '0')
                                                        SALAH
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $up->ragu == null ? 'TIDAK' : 'YA' }}
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

            <a href="{{ url('/instruktur/ujian/' . $ujian->kode) }}" class="btn btn-danger btn-sm"><span
                    data-feather="arrow-left-circle"></span> kembali</a>

        </div>
        @include('template.footer')
    </div>
    <!--  END CONTENT AREA  -->
    {!! session('pesan') !!}
    @include('error.ew-t-p-s')
@endsection
