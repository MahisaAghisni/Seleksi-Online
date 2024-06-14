@extends('template.main')
@section('content')
    @include('template.navbar.admin')
    {!! session('pesan') !!}
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-4 layout-spacing">
                    <div class="widget widget-five infobox-3" style="width: 100%; padding: 10px;">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <h5 class="info-heading mt-4 text-center">Jumlah Data Instruktur</h5>
                        <div class="widget-content">
                            <div class="w-content" style="padding: 0;">
                                <div class="">
                                    <p class="task-left">{{ $instruktur->count() }}</p>
                                    @php
                                        $aktif = $instruktur->count();
                                        $tidak_aktif = 0;
                                    @endphp

                                    @foreach ($instruktur as $ins)
                                        @if ($ins->is_active == 0)
                                            @php
                                                $tidak_aktif++;
                                                $aktif--;
                                            @endphp
                                        @endif
                                    @endforeach
                                    <p class="task-completed"><span>{{ $aktif }} Instruktur</span> Aktif</p>
                                    {!! $tidak_aktif != 0
                                        ? '<p class="task-hight-priority"><span>' . $tidak_aktif . ' Instruktur</span> Tidak Aktif</p>'
                                        : '' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 layout-spacing">
                    <div class="widget widget-five infobox-3" style="width: 100%; padding: 10px;">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <h5 class="info-heading mt-4 text-center">Jumlah Data Peserta</h5>
                        <div class="widget-content">
                            <div class="w-content" style="padding: 0;">
                                <div class="">
                                    <p class="task-left">{{ $peserta->count() }}</p>
                                    @php
                                        $aktif = $peserta->count();
                                        $tidak_aktif = 0;
                                    @endphp

                                    @foreach ($peserta as $p)
                                        @if ($p->is_active == 0)
                                            @php
                                                $tidak_aktif++;
                                                $aktif--;
                                            @endphp
                                        @endif
                                    @endforeach
                                    <p class="task-completed"><span>{{ $aktif }} Peserta</span> Aktif</p>
                                    {!! $tidak_aktif != 0
                                        ? '<p class="task-hight-priority"><span>' . $tidak_aktif . ' Peserta</span> Tidak Aktif</p>'
                                        : '' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 layout-spacing">
                    <div class="widget widget-five infobox-3" style="width: 100%; padding: 10px;">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                        <h5 class="info-heading mt-4 text-center">Jumlah Data Pelatihan</h5>
                        <div class="widget-content">
                            <div class="w-content" style="padding: 0;">
                                <div class="">
                                    <p class="task-left">{{ $pelatihan->count() }}</p>
                                    <p class="task-completed"><span>{{ $pelatihan->count() }} Pelatihan</span> Aktif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('template.footer')
    </div>
@endsection
