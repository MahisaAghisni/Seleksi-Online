@extends('template.main')
@section('content')
    @include('template.navbar.admin')


    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <h4 class="mt-3">Relasi : {{ $instruktur->nama_instruktur }}</h4>
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3">
                        <div class="widget-heading ">
                            <h5 class="text-center">Relasi Pengajar - Pelatihan</h5>
                            <form action="" method="POST">
                                <table class="table table-bordered mt-4">
                                    <thead>
                                        <tr>
                                            <th>Pelatihan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pelatihan as $pel)
                                            <tr>
                                                <td>{{ $pel->nama_pelatihan }}</td>
                                                <td>
                                                    <label class="new-control new-checkbox checkbox-primary">
                                                        <input type="checkbox" class="new-control-input check-pelatihan"
                                                            {{ check_pelatihan($instruktur->id, $pel->id) }}
                                                            data-id_instruktur="{{ $instruktur->id }}"
                                                            data-id_pelatihan="{{ $pel->id }}">
                                                        <span class="new-control-indicator"></span> Mengajar
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-lg-6">
                    <div class="widget shadow p-3">
                        <div class="widget-heading text-center">
                            <h5 class="text-center">Relasi Pengajar - Mapel</h5>
                            <form action="" method="POST">
                                <table class="table table-bordered mt-2">
                                    <thead>
                                        <tr>
                                            <th>Mapel</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mapel as $m)
                                            <tr>
                                                <td>{{ $m->nama_mapel }}</td>
                                                <td>
                                                    <label class="new-control new-checkbox checkbox-primary">
                                                        <input type="checkbox" class="new-control-input check-mapel"
                                                            {{ check_mapel($guru->id, $m->id) }}
                                                            data-id_guru="{{ $guru->id }}"
                                                            data-id_mapel="{{ $m->id }}">
                                                        <span class="new-control-indicator"></span> Mengajar
                                                    </label>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
        @include('template.footer')
    </div>

    <!--  END CONTENT AREA  -->

    <script>
        $(document).ready(function() {
            $(".check-pelatihan").on("click", function() {
                var a = $(this).data("id_instruktur"),
                    e = $(this).data("id_pelatihan");
                $.ajax({
                    type: "get",
                    data: {
                        id_instruktur: a,
                        id_pelatihan: e
                    },
                    async: !0,
                    url: "{{ route('instruktur_pelatihan') }}",
                    success: function() {
                        swal({
                            title: "Berhasil!",
                            text: "relasi di ubah!",
                            type: "success",
                            padding: "2em"
                        })
                    }
                })
            })
        });
    </script>

    {!! session('pesan') !!}
@endsection
