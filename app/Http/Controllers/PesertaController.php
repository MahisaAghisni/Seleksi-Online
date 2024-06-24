<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use App\Models\WaktuUjian;

class PesertaController extends Controller
{
    public function index()
    {
        $notif_ujian = WaktuUjian::where('peserta_id', session()->get('id'))
            ->where('selesai', null)
            ->whereHas('ujian', function ($query) {
                $query->where('is_active', true);
            })
            ->get();

        $peserta = Peserta::firstWhere('id', session()->get('id'));

        return view(
            'peserta.dashboard',
            [
                'title' => 'Dashboard Peserta',
                'plugin' => '
                <link href="' . url("/assets/template") . '/assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/template") . '/assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/template") . '/assets/css/elements/infobox.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/template") . '/assets/js/dashboard/dash_1.js"></script>
            ',
                'menu' => [
                    'menu' => 'dashboard',
                    'expanded' => 'dashboard'
                ],
                'peserta' => $peserta,
                'notif_ujian' => $notif_ujian,
            ]
        );
    }
}
