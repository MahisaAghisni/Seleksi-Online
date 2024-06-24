<?php

namespace App\Http\Controllers;

use App\Models\DetailUjian;
use App\Models\Peserta;
use App\Models\PgPeserta;
use App\Models\Ujian;
use App\Models\WaktuUjian;
use Illuminate\Http\Request;

class UjianPesertaController extends Controller
{
    public function index()
    {
        $notif_ujian = WaktuUjian::where('peserta_id', session()->get('id'))
            ->where('selesai', null)
            ->get();
        $ujian = WaktuUjian::where('peserta_id', session()->get('id'))
            ->whereHas('ujian', function ($query) {
                $query->where('is_active', true);
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('peserta.ujian.index', [
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
            'peserta' => Peserta::firstWhere('id', session()->get('id')),
            'notif_ujian' => $notif_ujian,
            'ujian' => $ujian
        ]);
    }

    public function store(Request $request)
    {
        WaktuUjian::where('kode', $request->kode)
            ->where('peserta_id', session()->get('id'))
            ->update(['selesai' => 1]);

        return redirect('/peserta/ujian/' . $request->kode)->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'ujian sudah dikerjakan!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function show(Ujian $ujian)
    {
        $notif_ujian = WaktuUjian::where('peserta_id', session()->get('id'))
            ->where('selesai', null)
            ->get();

        $pg_peserta = PgPeserta::where('kode', $ujian->kode)
            ->where('peserta_id', session()->get('id'))
            ->get();
        if ($pg_peserta->count() == 0) {
            $data_pg_peserta = [];
            foreach ($ujian->detailujian as $soal) {
                array_push($data_pg_peserta, [
                    'detail_ujian_id' => $soal->id,
                    'kode' => $soal->kode,
                    'peserta_id' => session()->get('id')
                ]);
            }

            if ($ujian->acak == 1) {
                $randomize = collect($data_pg_peserta)->shuffle();
                $soal_pg_peserta = $randomize->toArray();
            } else {
                $soal_pg_peserta = $data_pg_peserta;
            }
            date_default_timezone_set('Asia/Jakarta');
            $timestamp = strtotime(date('Y-m-d H:i:s', time()));
            $waktu_berakhir = date('Y-m-d H:i:s', strtotime("+$ujian->jam hour +$ujian->menit minute", $timestamp));
            $data_waktu_ujian = [
                'waktu_berakhir' => $waktu_berakhir
            ];
            WaktuUjian::where('kode', $ujian->kode)
                ->where('peserta_id', session()->get('id'))
                ->update($data_waktu_ujian);

            PgPeserta::insert($soal_pg_peserta);
        }

        $waktu_ujian = WaktuUjian::where('kode', $ujian->kode)
            ->where('peserta_id', session()->get('id'))
            ->first();
        $pg_peserta = PgPeserta::where('kode', $ujian->kode)
            ->where('peserta_id', session()->get('id'))
            ->get();

        return view('peserta.ujian.show', [
            'title' => 'Ujian Pilihan Ganda',
            'plugin' => '
                <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
            ',
            'menu' => [
                'menu' => 'ujian',
                'expanded' => 'ujian'
            ],
            'peserta' => Peserta::firstWhere('id', session()->get('id')),
            'notif_ujian' => $notif_ujian,
            'ujian' => $ujian,
            'pg_peserta' => $pg_peserta,
            'waktu_ujian' => $waktu_ujian
        ]);
    }

    public function simpan_pg(Request $request)
    {
        $id_detail_ujian = $request->idDetail;
        $id_pg = $request->id_pg;
        $jawaban = $request->jawaban;

        $detail_ujian = DetailUjian::firstWhere('id', $id_detail_ujian);

        if ($jawaban == $detail_ujian->jawaban) {
            $benar = 1;
        } else {
            $benar = 0;
        }

        $data = [
            'jawaban' => $jawaban,
            'benar' => $benar
        ];
        try {
            PgPeserta::where('id', $id_pg)
                ->update($data);
            echo 'jawaban dikirim';
        } catch (\Exception $exeption) {
            echo $exeption->getMessage();
        }
    }
    public function ragu_pg(Request $request)
    {
        PgPeserta::where('id', $request->id_pg)
            ->update(['ragu' => $request->ragu]);
        echo 'checked ragu';
    }
}
