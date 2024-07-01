<?php

namespace App\Http\Controllers;

use App\Models\EmailSettings;
use App\Models\Admin;
use App\Exports\InstrukturExport;
use App\Exports\PesertaExport;
use App\Imports\InstrukturImport;
use App\Imports\PesertaImport;
use App\Mail\NotifAkun;
use App\Models\Anggaran;
use App\Models\DetailEssay;
use App\Models\DetailGelombang;
use App\Models\DetailUjian;
use App\Models\EssayPeserta;
use App\Models\gelombang;
use App\Models\Gelombang as ModelsGelombang;
use App\Models\Instruktur;
use App\Models\Instrukturmapel;
use App\Models\Instrukturpelatihan;
use App\Models\Pelatihan;
use App\Models\Pelatihans;
use App\Models\Peserta;
use App\Models\PgPeserta;
use App\Models\Seleksi;
use App\Models\Ujian;
use App\Models\WaktuUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{

    public function index()
    {
        return view('admin.dashboard', [
            'title' => 'Dashboard Admin',
            'plugin' => '
                <link href="' . url("/assets/template") . '/assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/template") . '/assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/template") . '/assets/css/elements/infobox.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/template") . '/assets/js/dashboard/dash_1.js"></script>
            ',
            'menu' => [
                'menu' => 'dashboard',
                'expanded' => 'dashboard',
                'collapse' => '',
                'sub' => '',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'instruktur' => Instruktur::all(),
            'peserta' => Peserta::all(),
            'pelatihan' => Pelatihan::all(),
        ]);
    }
    public function filter_peserta(Request $request)
    {
        // $data = Peserta::where('idGelombang', $request->idGelombang)->where('pelatihan', $request->pelatihan)->with('pelatihans')->get();
        $idGelombang = $request->idGelombang;
        $pelatihan = $request->pelatihan;

        if (!empty($idGelombang) && !empty($pelatihan)) {
            $data = Peserta::where('idGelombang', $idGelombang)->where('pelatihan', $pelatihan)->with('pelatihans')->get();
        } else {
            $data = [];
        }

        return view('admin.peserta.index', [
            'title' => 'Data Peserta',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/template") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
                ',
            'menu' => [
                'menu' => 'master',
                'expanded' => 'master',
                'collapse' => 'master',
                'sub' => 'peserta',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'gelombang' => Gelombang::all(),
            'peserta' => $data,
            'pelatihan' => Pelatihan::all(),
            'idGelombang' => $idGelombang,
            'pelatihanSelected' => $pelatihan,
        ]);
    }

    public function profile()
    {
        return view('admin.profile-settings', [
            'title' => 'Profile and Settings',
            'plugin' => '
                <link href="' . url("assets/template") . '/assets/css/users/user-profile.css" rel="stylesheet" type="text/css" />
                <link rel="stylesheet" type="text/css" href="' . url("assets/template") . '/assets/css/forms/theme-checkbox-radio.css">
            ',
            'menu' => [
                'menu' => 'profile',
                'expanded' => 'profile',
                'collapse' => '',
                'sub' => '',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'email_settings' => EmailSettings::first()
        ]);
    }
    public function edit_profile(Request $request, Admin $admin)
    {
        $rules = [
            'nama_admin' => 'required|max:255',
            'avatar' => 'image|file|max:1024',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('avatar')) {
            if ($request->gambar_lama && $request->gambar_lama != 'default.png') {
                $oldAvatarPath = public_path('assets/user-profile/' . $request->gambar_lama);
                if (file_exists($oldAvatarPath)) {
                    unlink($oldAvatarPath);
                }
            }
            $avatarFile = $request->file('avatar');
            $avatarFileName = time() . '_' . $avatarFile->getClientOriginalName();
            $avatarFile->move(
                public_path('assets/user-profile'),
                $avatarFileName
            );
            $validatedData['avatar'] = $avatarFileName;
        }

        Admin::where('id', $admin->id)
            ->update($validatedData);

        return redirect('/admin/profile')->with('pesan', "
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
    public function edit_password(Request $request, Admin $admin)
    {
        if (Hash::check($request->current_password, $admin->password)) {
            $data = [
                'password' => bcrypt($request->password)
            ];
            Admin::where('id', $admin->id)
                ->update($data);

            return redirect('/admin/profile')->with('pesan', "
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

        return redirect('/admin/profile')->with('pesan', "
            <script>
                swal({
                    title: 'Error!',
                    text: 'current password salah!',
                    type: 'error',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function smtp_email(Request $request, $id)
    {
        $data = [
            'notif_akun' => $request->notif_akun,
            'notif_ujian' => $request->notif_ujian,
        ];

        EmailSettings::where('id', $id)
            ->update($data);

        return redirect('/admin/profile')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'pengaturan email di ubah!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    # start instruktur
    public function instruktur()
    {
        return view('admin.instruktur.index', [
            'title' => 'Data Instruktur',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/template") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
                ',
            'menu' => [
                'menu' => 'master',
                'expanded' => 'master',
                'collapse' => 'master',
                'sub' => 'instruktur',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'instruktur' => Instruktur::all()
        ]);
    }

    public function tambah_instruktur(Request $request)
    {
        $email_settings = EmailSettings::first();

        $emails = $request->get('email');

        $instrukturs = [];
        $email_sebelumnya = '';
        $index = 0;

        foreach ($emails as $email) {

            if ($email == $email_sebelumnya) {
                return redirect('/admin/instruktur')->with('pesan', "
                    <script>
                        swal({
                            title: 'Error!',
                            text: 'Duplicate data email detected!',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }
            array_push($instrukturs, [
                'nama_instruktur' => $request['nama_instruktur'][$index],
                'gender' => $request['gender'][$index],
                'email' => $email,
                'password' => bcrypt('123'),
                'avatar' => 'default.png',
                'role' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]);

            $email_sebelumnya = $email;
            $index++;
        }

        try {
            Instruktur::insert($instrukturs);

            if ($email_settings->notif_akun == '1') {
                foreach ($instrukturs as $s) {
                    // Kirim Email ke Instruktur
                    $details = [
                        'nama' => $s['nama_instruktur'],
                        'email' => $s['email'],
                        'password' => '123'
                    ];
                    Mail::to($details['email'])->send(new NotifAkun($details));
                }
            }

            return redirect('/admin/instruktur')->with('pesan', "
                <script>
                    swal({
                        title: 'Berhasil!',
                        text: 'data instruktur di simpan!',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
        } catch (\Exception $exceptions) {
            $pesan_error = str_replace('\'', '\`', $exceptions->errorInfo[2]);
            return redirect('/admin/instruktur')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: '$pesan_error',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ");
        }
    }



    public function edit_instruktur(Request $request)
    {
        $id_instruktur = $request->id_instruktur;
        $instruktur = Instruktur::firstWhere('id', $id_instruktur);
        echo json_encode($instruktur);
    }

    public function edit_instruktur_(Request $request)
    {
        $instruktur = Instruktur::firstWhere('id', $request->input('id'));
        $rules = [
            'nama_instruktur' => 'required',
            'gender' => 'required',
            'is_active' => 'required'
        ];

        if ($request->input('email') != $instruktur->email) {
            $rules['email'] = 'required|email:dns|unique:instrukturs';
        }

        $validate = $request->validate($rules);

        Instruktur::where('id', $request->input('id'))
            ->update($validate);

        return redirect('/admin/instruktur')->with('pesan', "
        <script>
                swal({
                    title: 'Berhasil!',
                    text: 'data instruktur di edit!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function impor_instruktur()
    {
        return response()->download('assets/file-excel/instruktur.xlsx');
    }

    public function impor_instruktur_(Request $request)
    {
        $email_settings = EmailSettings::first();

        $instruktur_excel = Excel::toArray(new InstrukturImport, $request->file);
        if (count($instruktur_excel) < 0) {
            return redirect('/admin/instruktur')->with('pesan', "
                <script>
                    swal({
                        title: 'Info!',
                        text: 'tidak ada data di dalam file yang di upload',
                        type: 'info',
                        padding: '2em'
                    })
                </script>
            ");
        }

        try {
            $list_instruktur = [];
            foreach ($instruktur_excel[0] as $instruktur) {
                if ($instruktur['nama_instruktur'] !== null) {
                    array_push($list_instruktur, [
                        'nama_instruktur' => $instruktur['nama_instruktur'],
                        'gender' => $instruktur['gender'],
                        'email' => $instruktur['email'],
                        'password' => bcrypt('123'),
                        'avatar' => 'default.png',
                        'role' => 2,
                        'is_active' => 1
                    ]);
                }
            }

            Instruktur::insert($list_instruktur);

            if ($email_settings->notif_akun == '1') {
                foreach ($instruktur_excel[0] as $s) {
                    // Kirim Email ke Instruktur
                    $details = [
                        'nama' => $s['nama_instruktur'],
                        'email' => $s['email'],
                        'password' => '123'
                    ];
                    Mail::to($details['email'])->send(new NotifAkun($details));
                }
            }

            return redirect('/admin/instruktur')->with('pesan', "
                <script>
                    swal({
                        title: 'Berhasil!',
                        text: 'import data instruktur berhasil!',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
        } catch (\Exception $exceptions) {
            if ($exceptions->getCode() != 0) {
                $pesan_error = str_replace('\'', '\`', $exceptions->errorInfo[2]);
            } else {
                $pesan_error = $exceptions->getMessage();
            }

            return redirect('/admin/instruktur')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: '$pesan_error',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ");
        }
    }

    public function hapus_instruktur(Instruktur $instruktur)
    {
        Instrukturpelatihan::where('instruktur_id', $instruktur->id)
            ->delete();

        $ujian = Ujian::where('instruktur_id', $instruktur->id)->get();
        foreach ($ujian as $u) {
            DetailUjian::where('kode', $u->kode)
                ->delete();
            PgPeserta::where('kode', $u->kode)
                ->delete();
            WaktuUjian::where('kode', $u->kode)
                ->delete();
        }
        Ujian::where('instruktur_id', $instruktur->id)
            ->delete();

        Instruktur::destroy($instruktur->id);
        return redirect('/admin/instruktur')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'data instruktur berhasil di hapus!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function ekspor_instruktur()
    {
        return Excel::download(new InstrukturExport, 'data-instruktur.xlsx');
    }


    #Start Peserta
    public function peserta()
    {
        return view('admin.peserta.index', [
            'title' => 'Data Peserta',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/template") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
                ',
            'menu' => [
                'menu' => 'master',
                'expanded' => 'master',
                'collapse' => 'master',
                'sub' => 'peserta',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'gelombang' => Gelombang::all(),
            'peserta' => Peserta::with('pelatihans')->get(),
            'pelatihan' => Pelatihan::all()
        ]);
    }

    #Start Pelatihan
    public function pelatihan()
    {
        return view('admin.pelatihan.index', [
            'title' => 'Data Pelatihan',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/template") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
            ',
            'menu' => [
                'menu' => 'pelatihan',
                'expanded' => 'pelatihan',
                'collapse' => '',
                'sub' => '',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'pelatihan' => Pelatihan::all()
        ]);
    }

    #Start Gelombang
    public function gelombang()
    {
        $datas = DetailGelombang::select('idGelombang')->distinct()->get();

        return view('admin.gelombang.index', [
            'title' => 'Data Gelombang',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/template") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
            ',
            'menu' => [
                'menu' => 'gelombang',
                'expanded' => 'gelombang',
                'collapse' => '',
                'sub' => '',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'gelombang' => $datas,
            'anggaran' => Anggaran::all(),
            'dataGelombang' => Gelombang::all()
        ]);
    }

    public function filter_list_gelombang(Request $request)
    {
        $idGelombang = $request->idGelombang;

        if (!empty($idGelombang)) {
            $datas = DetailGelombang::where('idGelombang', $idGelombang)
                ->get();


            foreach ($datas as $detail) {
                $idGelombang = $detail->idGelombang;

                // Menggunakan relasi Peserta->Pelatihan untuk menghitung jumlah peserta berdasarkan pelatihan
                $jumlahPeserta =
                    $jumlahPeserta = Peserta::where('idGelombang', $idGelombang)->whereHas('pelatihans', function ($query) use ($detail) {
                        $query->where('id', $detail->pelatihans->id);
                    })->count();

                $detail->jumlah_peserta = $jumlahPeserta;

                $ujianAktif = Ujian::where('pelatihan_id', $detail->pelatihans->id)
                    ->where('gelombang_id', $idGelombang)
                    ->where('is_active', 1)
                    ->first();

                $detail->ujian_aktif = $ujianAktif;
            }
        } else {
            $datas = [];
        }

        $dataSeleksi = Seleksi::where('idGelombang', $idGelombang)->get();
        $pluck = $datas->pluck('idPelatihan')->toArray();

        $rawData = [];
        foreach ($datas as $index => $value) {

            // cari dataSeleksi yang memiliki idPelatihan sama dengan idPelatihan pada $value
            $dataFound = $dataSeleksi->where('idPelatihan', $value->idPelatihan)->first();

            $value->dataSeleksi = $dataFound;
        }

        return view('admin.gelombang.index', [
            'title' => 'Data Gelombang',
            'plugin' => '
            <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/datatables.css">
            <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/dt-global_style.css">
            <script src="' . url("/assets/template") . '/plugins/table/datatable/datatables.js"></script>
            <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
        ',
            'menu' => [
                'menu' => 'gelombang',
                'expanded' => 'gelombang',
                'collapse' => '',
                'sub' => '',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'gelombang' => $datas,
            'anggaran' => Anggaran::all(),
            'dataGelombang' => Gelombang::all(),
            'idGelombang' => $idGelombang
        ]);
    }

    public function show_gelombang(Request $request)
    {
        $id = $request->id_instruktur;
        $dataGelombang = DetailGelombang::firstWhere('id', $id);
        $data = gelombang::firstWhere('id', $dataGelombang->idGelombang);
        echo json_encode($data);
    }

    public function edit_gelombang(Request $request)
    {

        $gelombangDetail = DetailGelombang::firstWhere('id', $request->id);
        $data = Seleksi::where('idGelombang', $gelombangDetail->idGelombang)->where('idPelatihan', $gelombangDetail->idPelatihan)->get();
        foreach ($data as $d) {
            $d->tanggal = $request->tanggal;
            $d->jam = $request->jam;
            $d->save();
        }

        return redirect('/admin/gelombang')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'Seleksi updated!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function filter_gelombang($id)
    {
        $data =
            DetailGelombang::with('pelatihans')->where('idGelombang', $id)->get();
        return response()->json($data);
    }

    #Start Relasi
    public function relasi()
    {
        return view('admin.instruktur.relasi-index', [
            'title' => 'Data Relasi',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/template") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/template") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
            ',
            'menu' => [
                'menu' => 'relasi',
                'expanded' => 'relasi',
                'collapse' => '',
                'sub' => '',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'instruktur' => Instruktur::all()
        ]);
    }

    public function relasi_instruktur(Instruktur $instruktur)
    {
        // dd($instruktur);
        return view('admin.instruktur.relasi-instruktur', [
            'title' => 'Data Relasi',
            'plugin' => '

            ',
            'menu' => [
                'menu' => 'relasi',
                'expanded' => 'relasi',
                'collapse' => '',
                'sub' => '',
            ],
            'admin' => Admin::firstWhere('id', session()->get('id')),
            'instruktur' => $instruktur,
            'pelatihan' => Pelatihan::all(),
        ]);
    }

    public function instruktur_pelatihan(Request $request)
    {
        $id_instruktur = $request->id_instruktur;
        $id_pelatihan = $request->id_pelatihan;

        $where = [
            'instruktur_id' => $id_instruktur,
            'pelatihan_id' => $id_pelatihan,
        ];

        $result = Instrukturpelatihan::where($where)->get();

        if (count($result) > 0) {
            Instrukturpelatihan::where($where)
                ->delete();
        } else {
            Instrukturpelatihan::insert($where);
        }
    }
}
