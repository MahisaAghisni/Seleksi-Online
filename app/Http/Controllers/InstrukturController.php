<?php

namespace App\Http\Controllers;

use App\Models\Instruktur;
use App\Models\Instrukturpelatihan;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class InstrukturController extends Controller
{
    //
    public function index()
    {
        return view('instruktur.dashboard', [
            'title' => 'Dashboard Instruktur',
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
            'instruktur' => Instruktur::firstWhere('id', session()->get('id')),
            'instruktur_pelatihan' => Instrukturpelatihan::where('instruktur_id', session()->get('id'))->get()
        ]);
    }
    public function profile()
    {
        return view('instruktur.profile', [
            'title' => 'My Profile',
            'plugin' => '
                <link href="' . url("assets/template") . '/assets/css/users/user-profile.css" rel="stylesheet" type="text/css" />
            ',
            'menu' => [
                'menu' => 'profile',
                'expanded' => 'profile'
            ],
            'instruktur' => Instruktur::firstWhere('id', session()->get('id'))
        ]);
    }
    public function edit_profile(Instruktur $instruktur, Request $request)
    {
        $rules = [
            'nama_instruktur' => 'required|max:255',
            'avatar' => 'image|file|max:1024',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('avatar')) {
            if ($request->gambar_lama) {
                if ($request->gambar_lama != 'default.png') {
                    $oldAvatarPath = public_path('assets/user-profile/' . $request->gambar_lama);
                    if (file_exists($oldAvatarPath)) {
                        unlink($oldAvatarPath);
                    }
                }
            }

            $avatarFile = $request->file('avatar');
            $avatarFileName = time() . '_' . $avatarFile->getClientOriginalName();
            $avatarFile->move(public_path('assets/user-profile'), $avatarFileName);

            $validatedData['avatar'] = $avatarFileName;
        }

        Instruktur::where('id', $instruktur->id)->update($validatedData);

        return redirect('/instruktur/profile')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'profile updated!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function edit_password(Instruktur $instruktur, Request $request)
    {
        if (Hash::check(request('current_password', $instruktur->password))) {
            $data = [
                'password' => bcrypt($request->password)
            ];
            Instruktur::where('id', $instruktur->id)->update($data);

            return redirect('/instruktur/profile')->with('pesan', "
                <script>
                    swal({
                        title: 'Success!',
                        text: 'password updated!',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
        }

        return redirect('/instruktur/profile')->with('pesan', "
            <script>
                swal({
                    title: 'Failed!',
                    text: 'password not match!',
                    type: 'error',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function edit_ujian(Request $request, $id)
    {
        try {
            $ujian = Ujian::find($id);
            $ujian->update($request->query());
            return redirect('/instruktur/ujian')->with('pesan', "
                <script>
                    swal({
                        title: 'Success!',
                        text: 'ujian updated!',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
        } catch (\Throwable $th) {
            return redirect('/instruktur/ujian')->with('pesan', "
                <script>
                    swal({
                        title: 'Failed!',
                        text: 'ujian not updated!',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ");
        }
    }
}
