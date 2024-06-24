@extends('template.main')
@section('content')
    @include('template.navbar.instruktur')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <a href="javascript:void(0);" class="btn btn-primary tambah-pg"
            style="position: fixed; right: -10px; top: 50%; z-index: 9999;">Tambah Soal</a>
        <div class="layout-px-spacing">
            <form action="{{ url('/instruktur/ujian') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row layout-top-spacing">
                    <div class="col-lg-12 layout-spacing">
                        <div class="widget shadow p-3">
                            <div class="widget-heading">
                                <h5 class="">Ujian Pilihan Ganda</h5>
                                <a href="javascript:void(0);" class="btn btn-primary my-2" data-toggle="modal"
                                    data-target="#excel_ujian">Import Excel</a>
                                <div class="row mt-2">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Nama Ujian / Quiz</label>
                                            <input type="text" name="nama" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Pelatihan</label>
                                            <select class="form-control" name="pelatihan" id="pelatihan" required>
                                                <option value="">Pilih</option>
                                                @foreach ($instruktur_pelatihan as $ip)
                                                    <option value="{{ $ip->pelatihan->id }}">
                                                        {{ $ip->pelatihan->nama_pelatihan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Gelombang</label>
                                            <select class="form-control" name="gelombang" id="pelatihan" required>
                                                <option value="">Pilih</option>
                                                @foreach ($gelombang as $ip)
                                                    <option value="{{ $ip->id }}">
                                                        {{ $ip->tahun }}-{{ $ip->gelombang }}-{{ $ip->anggaran->nama_anggaran ?? '-' }}-{{ $ip->jenisPelatihan->pelatihan ?? '-' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Waktu Jam</label>
                                            <input type="number" name="jam" class="form-control" value="0"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="">Waktu Menit</label>
                                            <input type="number" name="menit" class="form-control" value="0"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1"
                                                name="acak" value="1">
                                            <label class="custom-control-label" for="customCheck1">Acak Soal</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row layout-top-spacing">
                    <div class="col-lg-12 layout-spacing">
                        <div class="widget shadow p-3">
                            <div class="widget-heading">
                                <h5 class="">Soal Ujian</h5>
                            </div>
                            <div id="soal_pg">
                                <div class="isi_soal">
                                    <div class="form-group">
                                        <label for="">Soal No. 1</label>
                                        <textarea name="soal[]" cols="30" rows="2" class="summernote" wrap="hard" required></textarea>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Pilihan A</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon5">A</span>
                                                    </div>
                                                    <input type="text" name="pg_1[]" class="form-control"
                                                        placeholder="Opsi A" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Pilihan B</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon5">B</span>
                                                    </div>
                                                    <input type="text" name="pg_2[]" class="form-control"
                                                        placeholder="Opsi B" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Pilihan C</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon5">C</span>
                                                    </div>
                                                    <input type="text" name="pg_3[]" class="form-control"
                                                        placeholder="Opsi C" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Pilihan D</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon5">D</span>
                                                    </div>
                                                    <input type="text" name="pg_4[]" class="form-control"
                                                        placeholder="Opsi D" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Pilihan E</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon5">E</span>
                                                    </div>
                                                    <input type="text" name="pg_5[]" class="form-control"
                                                        placeholder="Opsi E" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Jawaban</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon5">
                                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                                stroke="currentColor" stroke-width="2" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="css-i6dzq1">
                                                                <polyline points="20 6 9 17 4 12"></polyline>
                                                            </svg>
                                                        </span>
                                                    </div>
                                                    <select name="jawaban[]" class="form-control" required>
                                                        <option value="A">A</option>
                                                        <option value="B">B</option>
                                                        <option value="C">C</option>
                                                        <option value="D">D</option>
                                                        <option value="E">E</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @include('template.footer')
    </div>
    <!--  END CONTENT AREA  -->

    <!-- MODAL -->
    <!-- Modal Tambah -->
    <div class="modal fade" id="excel_ujian" tabindex="-1" role="dialog" aria-labelledby="excel_ujianLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ url('/instruktur/pg_excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="excel_ujianLabel">Import Soal via Excel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            x
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Nama Ujian / Quiz</label>
                                    <input type="text" name="e_nama_ujian" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Pelatihan</label>
                                    <select class="form-control" name="pelatihan" id="pelatihan" required>
                                        <option value="">Pilih</option>
                                        @foreach ($instruktur_pelatihan as $ip)
                                            <option value="{{ $ip->pelatihan->id }}">
                                                {{ $ip->pelatihan->nama_pelatihan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Gelombang</label>
                                    <select class="form-control" name="gelombang" id="pelatihan" required>
                                        <option value="">Pilih</option>
                                        @foreach ($gelombang as $ip)
                                            <option value="{{ $ip->id }}">
                                                Gelombang
                                                {{ $ip->tahun }}-{{ $ip->gelombang }}-{{ $ip->anggaran->nama_anggaran ?? '-' }}-{{ $ip->jenisPelatihan->pelatihan ?? '-' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Waktu Jam</label>
                                    <input type="number" name="e_jam" class="form-control" value="0" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">Waktu Menit</label>
                                    <input type="number" name="e_menit" class="form-control" value="0" required>
                                </div>
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="acak" name="e_acak"
                                        value="1">
                                    <label class="custom-control-label" for="acak">Acak Soal Peserta</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="">File Excel</label><br>
                                    <input type="file" name="excel" accept=".xls, .xlsx">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="">Template</label><br>
                                <a href="{{ url('/summernote/unduh') }}/template-pg-excel.xlsx" class="btn btn-success"
                                    target="_blank">Download Template</a>
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
    <script>
        $(document).ready(function() {
            function uploadImage(e, o) {
                var a = new FormData;
                a.append("image", e), $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    url: "{{ route('summernote_upload') }}",
                    cache: !1,
                    contentType: !1,
                    processData: !1,
                    data: a,
                    type: "post",
                    success: function(e) {
                        $(o).summernote("insertImage", e)
                    },
                    error: function(e) {
                        console.log(e)
                    }
                })
            }

            function deleteImage(e) {
                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    data: {
                        src: e
                    },
                    type: "post",
                    url: "{{ route('summernote_delete') }}",
                    cache: !1,
                    success: function(e) {
                        console.log(e)
                    }
                })
            }
            setInterval(() => {
                $(".summernote").summernote({
                    placeholder: "Hello stand alone ui",
                    tabsize: 2,
                    height: 120,
                    toolbar: [
                        ["style", ["style"]],
                        ["font", ["bold", "underline", "clear"]],
                        ["color", ["color"]],
                        ["para", ["ul", "ol", "paragraph"]],
                        ["table", ["table"]],
                        ["insert", ["link", "picture", "video"]],
                        ["view", ["fullscreen", "help"]]
                    ],
                    callbacks: {
                        onImageUpload: function(e, o = this) {
                            uploadImage(e[0], o)
                        },
                        onMediaDelete: function(e) {
                            deleteImage(e[0].src)
                        }
                    }
                })
            }, 1e3);
            var no_soal = 2;
            $('.tambah-pg').click(function() {
                const pg = `
                    <div class="isi_soal">
                    <hr>
                        <div class="form-group">
                            <label for="">Soal No . ` + no_soal + `</label>
                            <textarea name="soal[]" cols="30" rows="2" class="summernote" wrap="hard" required></textarea>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Pilihan A</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">A</span>
                                        </div>
                                        <input type="text" name="pg_1[]" class="form-control" placeholder="Opsi A" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Pilihan B</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">B</span>
                                        </div>
                                        <input type="text" name="pg_2[]" class="form-control" placeholder="Opsi B" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Pilihan C</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">C</span>
                                        </div>
                                        <input type="text" name="pg_3[]" class="form-control" placeholder="Opsi C" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Pilihan D</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">D</span>
                                        </div>
                                        <input type="text" name="pg_4[]" class="form-control" placeholder="Opsi D" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Pilihan E</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">E</span>
                                        </div>
                                        <input type="text" name="pg_5[]" class="form-control" placeholder="Opsi E" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Jawaban</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            </span>
                                        </div>
                                       <select name="jawaban[]" class="form-control" required>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="btn btn-danger hapus-pg">Hapus</a>
                    </div>
                `;

                $('#soal_pg').append(pg);
                no_soal++;
            });
            $("#soal_pg").on("click", ".isi_soal a", function() {
                $(this).parents(".isi_soal").remove(), --no_soal
            });
        })
    </script>

    {!! session('pesan') !!}
@endsection
