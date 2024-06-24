<?php

namespace App\Http\Controllers;

use App\Exports\PgExport;
use App\Imports\PgImport;
use App\Mail\NotifUjian;
use App\Models\DetailUjian;
use App\Models\EmailSettings;
use App\Models\Gelombang;
use App\Models\Instruktur;
use App\Models\Instrukturpelatihan;
use App\Models\DetailGelombang;
use App\Models\Peserta;
use App\Models\PgPeserta;
use App\Models\Seleksi;
use App\Models\Ujian;
use App\Models\WaktuUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class UjianInstrukturController extends Controller
{
    public function index()
    {
        return view('instruktur.ujian.index', [
            'title' => 'Data Ujian',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/template") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'instruktur' => Instruktur::firstWhere('id', session()->get('id')),
            'ujian' => Ujian::where('instruktur_id', session()->get('id'))->get(),
            'ujianActive' => Ujian::where('instruktur_id', session()->get('id'))->where('is_active', 1)->count(),
        ]);
    }


    public function create()
    {
        return view('instruktur.ujian.create', [
            'title' => 'Tambah Ujian',
            'plugin' => '
                <link href="' . url("/assets/template") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/template") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
                <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'gelombang' => Gelombang::where('is_active', 'Aktif')->get(),
            'instruktur' => Instruktur::firstWhere('id', session()->get('id')),
            'instruktur_pelatihan' => Instrukturpelatihan::Where('instruktur_id', session()->get('id'))->get(),
        ]);
    }

    public function store(Request $request)
    {
        $peserta = Peserta::where('pelatihan', $request->pelatihan)->where('idGelombang', $request->gelombang)->get();
        if ($peserta->count() == 0) {
            return redirect('/instruktur/ujian/create')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: 'belum ada peserta di pelatihan tersebut!',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ")->withInput();
        }
        $kode = Str::random(30);
        $ujian = [
            'kode' => $kode,
            'nama' => $request->nama,
            'instruktur_id' => session()->get('id'),
            'pelatihan_id' => $request->pelatihan,
            'gelombang_id' => $request->gelombang,
            'jam' => $request->jam,
            'menit' => $request->menit,
            'acak' => $request->acak,
        ];

        $detail_ujian = [];
        $index = 0;
        $nama_soal =  $request->soal;
        foreach ($nama_soal as $soal) {
            array_push($detail_ujian, [
                'kode' => $kode,
                'soal' => $soal,
                'pg_1' => 'A. ' . $request->pg_1[$index],
                'pg_2' => 'B. ' . $request->pg_2[$index],
                'pg_3' => 'C. ' . $request->pg_3[$index],
                'pg_4' => 'D. ' . $request->pg_4[$index],
                'pg_5' => 'E. ' . $request->pg_5[$index],
                'jawaban' => $request->jawaban[$index]
            ]);

            $index++;
        }

        $email_peserta = '';
        $waktu_ujian = [];
        foreach ($peserta as $p) {
            $email_peserta .= $p->email . ',';

            array_push($waktu_ujian, [
                'kode' => $kode,
                'peserta_id' => $p->id
            ]);
        }

        $email_peserta = Str::replaceLast(',', '', $email_peserta);
        $email_peserta = explode(',', $email_peserta);

        $email_settings = EmailSettings::first();
        if ($email_settings->notif_ujian == '1') {
            $details = [
                'nama_instruktur' => session()->get('nama_instruktur'),
                'nama_ujian' => $request->nama,
                'jam' => $request->jam,
                'menit' => $request->menit,
            ];
            Mail::to($email_peserta)->send(new NotifUjian($details));
        }

        $createUjian = Ujian::create($ujian);
        DetailUjian::insert($detail_ujian);
        WaktuUjian::insert($waktu_ujian);
        $data = [
            'idGelombang' => $request->gelombang,
            'idPelatihan' => $request->pelatihan,
            'idUjian' => $createUjian->id
        ];
        Seleksi::insert($data);

        return redirect('/instruktur/ujian')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'ujian sudah di posting!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function pg_excel(Request $request)
    {
        $peserta = Peserta::where('pelatihan', $request->pelatihan)->where('idGelombang', $request->gelombang)->get();
        if ($peserta->count() == 0) {
            return redirect('/instruktur/ujian/create')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: 'belum ada peserta di pelatihan tersebut!',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ")->withInput();
        }

        $kode = Str::random(30);
        $ujian = [
            'kode' => $kode,
            'nama' => $request->e_nama_ujian,
            'instruktur_id' => session()->get('id'),
            'pelatihan_id' => $request->pelatihan,
            'gelombang_id' => $request->gelombang,
            'jam' => $request->e_jam,
            'menit' => $request->e_menit,
            'acak' => $request->e_acak,
        ];

        $email_peserta = '';
        $waktu_ujian = [];
        foreach ($peserta as $p) {
            $email_peserta .= $p->email . ',';

            array_push($waktu_ujian, [
                'kode' => $kode,
                'peserta_id' => $p->id
            ]);
        }

        $email_peserta = Str::replaceLast(',', '', $email_peserta);
        $email_peserta = explode(',', $email_peserta);

        $email_settings = EmailSettings::first();
        if ($email_settings->notif_ujian == '1') {
            $details = [
                'nama_instruktur' => session()->get('nama_instruktur'),
                'nama_ujian' => $request->e_nama_ujian,
                'jam' => $request->e_jam,
                'menit' => $request->e_menit,
            ];
            Mail::to($email_peserta)->send(new NotifUjian($details));
        }

        $createUjian = Ujian::insertGetId($ujian); // Mengembalikan ID dari record yang baru dimasukkan

        // Pastikan insert berhasil sebelum melanjutkan
        if ($createUjian) {
            Excel::import(new PgImport($kode), $request->excel);
            WaktuUjian::insert($waktu_ujian);

            // Simpan detail gelombang dengan ID ujian yang baru saja dimasukkan
            $data = [
                'idGelombang' => $request->gelombang,
                'idPelatihan' => $request->pelatihan,
                'idUjian' => $createUjian
            ];
            Seleksi::insert($data);

            // Lanjutkan dengan pengiriman email dan operasi lainnya
        } else {
            // Jika insert gagal, lakukan penanganan kesalahan di sini
        }


        return redirect('/instruktur/ujian')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'ujian sudah di posting!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }


    public function show(Ujian $ujian)
    {
        return view('instruktur.ujian.show', [
            'title' => 'Detail Ujian',
            'plugin' => '
                <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'instruktur' => Instruktur::firstWhere('id', session()->get('id')),
            'ujian' => $ujian,
        ]);
    }

    public function pg_peserta($kode, $peserta_id)
    {
        $ujian_peserta = PgPeserta::where('kode', $kode)
            ->where('peserta_id', $peserta_id)
            ->get();
        return view('instruktur.ujian.show-peserta', [
            'title' => 'Detail Ujian Peserta',
            'plugin' => '
                <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'instruktur' => Instruktur::firstWhere('id', session()->get('id')),
            'ujian_peserta' => $ujian_peserta,
            'ujian' => Ujian::firstWhere('kode', $kode),
            'peserta' => Peserta::firstWhere('id', $peserta_id)
        ]);
    }

    public function destroy(Ujian $ujian)
    {

        WaktuUjian::where('kode', $ujian->kode)
            ->delete();

        DetailUjian::where('kode', $ujian->kode)
            ->delete();

        PgPeserta::where('kode', $ujian->kode)
            ->delete();

        Ujian::destroy($ujian->id);

        return redirect('/instruktur/ujian')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'ujian di hapus!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function ujian_cetak($kode)
    {
        return view('instruktur.ujian.cetak-pg', [
            'ujian' => Ujian::firstWhere('kode', $kode)
        ]);
    }
    public function ujian_ekspor($kode)
    {
        $ujian =  Ujian::firstWhere('kode', $kode);
        $nama_pelatihan = $ujian->pelatihan->nama_pelatihan;
        return Excel::download(new PgExport($ujian), "nilai-pg-pelatihan-$nama_pelatihan.xlsx");
    }
}
