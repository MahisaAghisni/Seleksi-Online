@extends('template.main')
@section('content')
    @include('template.navbar.peserta')


    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing">
                <div class="col-xl-6 col-lg-12 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-one p-3">
                        <div class="widget-heading">
                            <h5 class="">Notifikasi Ujian</h5>
                        </div>

                        <div class="widget-content">
                            @if ($notif_ujian->count() > 0)
                                @foreach ($notif_ujian as $nu)
                                    <div class="transactions-list mt-1">
                                        <div class="t-item">
                                            <div class="t-company-name">
                                                <div class="t-icon">
                                                    <div class="icon">
                                                        <span data-feather="cast"></span>
                                                    </div>
                                                </div>
                                                <div class="t-name">
                                                    <h4>
                                                        @if ($nu->ujian)
                                                            {{ $nu->ujian->nama }}
                                                        @endif
                                                    </h4>
                                                    <p class="meta-date">
                                                        @if ($nu->ujian)
                                                            {{ $nu->ujian->pelatihan->nama_pelatihan }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="transactions-list" style="border: 2px dashed #e7515a;">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4 style="color: #e7515a;">Tidak ada ujian untuk saat ini
                                                    <span data-feather="smile"></span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="footer-wrapper">
            <div class="footer-section f-section-1">
                <p class="">Copyright © 2024 <a target="_blank" href="https://blksumenep.com/"
                        class="text-primary">BLK
                        Sumenep</a></p>
            </div>
            <div class="footer-section f-section-2">
                <p class="">BLK Sumenep</p>
            </div>
        </div>
    </div>
    <!--  END CONTENT AREA  -->


    {!! session('pesan') !!}

@endsection
