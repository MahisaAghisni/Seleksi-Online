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

    // public function profile()
    // {
    //     $notif_ujian = WaktuUjian::where('peserta_id', session()->get('id'))->where('selesai', null)->get();

    //     return view('peserta.profile', [
    //         'title' => 'Profile Peserta',
    //         'plugin' => '
    //         <link href="' . url("/assets/template") . '/assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
    //         <link href="' . url("/assets/template") . '/assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
    //         <link href="' . url("/assets/template") . '/assets/css/elements/infobox.css" rel="stylesheet" type="text/css" />
    //         <script src="' . url("/assets/template") . '/assets/js/dashboard/dash_1.js"></script>
    //     ',
    //         'menu' => [
    //             'menu' => 'profile',
    //             'expanded' => 'profile'
    //         ],
    //         'peserta' => Peserta::firstWhere('id', session()->get('id')),
    //         'notif_ujian' => $notif_ujian,
    //     ]);
    // }
    // public function edit_profile(Peserta $peserta, Request $request)
    // {
    //     $rules = [
    //         'firstname' => 'required|max:255',
    //         'avatar' => 'image|file|max:1024',
    //     ];

    //     $validatedData = $request->validate($rules);

    //     if ($request->file('avatar')) {
    //         if ($request->gambar_lama) {
    //             if ($request->gambar_lama != 'default.png') {
    //                 Storage::delete('assetsuser-profile/' . $request->gambar_lama);
    //             }
    //         }
    //         $validatedData['avatar'] = str_replace('assets/user-profile/', '', $request->file('avatar')->store('assets/user-profile'));
    //     }
    //     Peserta::where('id', $peserta->id)
    //         ->update($validatedData);

    //     return redirect('/peserta/profile')->with('pesan', "
    //         <script>
    //             swal({
    //                 title: 'Success!',
    //                 text: 'profile updated!',
    //                 type: 'success',
    //                 padding: '2em'
    //             })
    //         </script>
    //     ");
    // }
    // public function edit_password(Request $request, Peserta $peserta)
    // {
    //     if (Hash::check($request->current_password, $peserta->password)) {
    //         $data = [
    //             'password' => bcrypt($request->password)
    //         ];
    //         peserta::where('id', $peserta->id)
    //             ->update($data);

    //         return redirect('/peserta/profile')->with('pesan', "
    //             <script>
    //                 swal({
    //                     title: 'Success!',
    //                     text: 'password updated!',
    //                     type: 'success',
    //                     padding: '2em'
    //                 })
    //             </script>
    //         ");
    //     }

    //     return redirect('/peserta/profile')->with('pesan', "
    //         <script>
    //             swal({
    //                 title: 'Error!',
    //                 text: 'current password salah!',
    //                 type: 'error',
    //                 padding: '2em'
    //             })
    //         </script>
    //     ");
    // }
}
