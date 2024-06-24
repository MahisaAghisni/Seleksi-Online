<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\Admin;
use App\Models\Gelombang;
use App\Models\Token;
use Illuminate\Support\Str;
use App\Models\Instruktur;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        if (session('admin') != null) {
            return redirect('/admin');
        }

        return view('auth.login', [
            "title" => "Login Form",
            "admin" => Admin::all()
        ]);
    }

    // public function index_blk()
    // {
    //     if (session('admin') != null) {
    //         return redirect('/admin');
    //     }

    //     return view('auth.login_blk', [
    //         "title" => "Login Form",
    //         "admin" => Admin::all()
    //     ]);
    // }

    public function login(Request $request)
    {
        $admin = Admin::firstWhere('email', $request->input('email'));
        if ($admin) {
            if (Hash::check($request->input('password'), $admin->password)) {
                $request->session()->put('id', $admin->id);
                $request->session()->put('email', $admin->email);
                $request->session()->put('role', 1);
                return redirect()->intended('/admin')->with('pesan', "
                    <script>
                        swal({
                            title: 'Berhasil!',
                            text: 'login berhasil',
                            type: 'success',
                            padding: '2em'
                        })
                    </script>
                ");
            } else {
                return redirect('/')->with('pesan', "
                    <script>
                        swal({
                            title: 'Login Failed!',
                            text: 'Password salah',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }
        }

        $instruktur = Instruktur::firstWhere('email', $request->input('email'));
        if ($instruktur) {

            if ($instruktur->is_active == 0) {
                return redirect('/')->with('pesan', "
                    <script>
                        swal({
                            title: 'Login Failed!',
                            text: 'akun tidak aktif',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }

            if (Hash::check($request->input('password'), $instruktur->password)) {
                $request->session()->put('id', $instruktur->id);
                $request->session()->put('email', $instruktur->email);
                $request->session()->put('nama_instruktur', $instruktur->nama_instruktur);
                $request->session()->put('role', 2);
                return redirect()->intended('/instruktur')->with('pesan', "
                    <script>
                        swal({
                            title: 'Berhasil!',
                            text: 'login berhasil',
                            type: 'success',
                            padding: '2em'
                        })
                    </script>
                ");
            } else {
                return redirect('/')->with('pesan', "
                    <script>
                        swal({
                            title: 'Login Failed!',
                            text: 'Password salah',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }
        }

        $gelombang_aktif = Gelombang::getActiveGelombang()->pluck('id')->toArray();

        $peserta_list = Peserta::where('idGelombang', $gelombang_aktif)->get();

        $peserta = $peserta_list->firstWhere('ktp', $request->input('email'));

        if ($peserta) {
            if ($peserta->is_active == 0) {
                return redirect('/')->with('pesan', "
                    <script>
                        swal({
                            title: 'Login Failed!',
                            text: 'akun tidak aktif',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }

            if ($request->input('password') == $peserta->password) {
                $request->session()->put('id', $peserta->id);
                $request->session()->put('ktp', $peserta->ktp);
                $request->session()->put('role', 3);
                return redirect()->intended('/peserta')->with('pesan', "
                    <script>
                        swal({
                            title: 'Berhasil!',
                            text: 'login berhasil',
                            type: 'success',
                            padding: '2em'
                        })
                    </script>
                ");
            } else {
                return redirect('/')->with('pesan', "
                    <script>
                        swal({
                            title: 'Login Failed!',
                            text: 'Password salah',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }
        }

        return redirect('/')->with('pesan', "
            <script>
                swal({
                    title: 'Login Failed!',
                    text: 'Akun tidak ditemukan',
                    type: 'error',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function login_blk(Request $request)
    {
        $admin = Admin::firstWhere('email', $request->input('email'));
        if ($admin) {
            if (Hash::check($request->input('password'), $admin->password)) {
                $request->session()->put('id', $admin->id);
                $request->session()->put('email', $admin->email);
                $request->session()->put('role', 1);
                return redirect()->intended('/admin')->with('pesan', "
                    <script>
                        swal({
                            title: 'Berhasil!',
                            text: 'login berhasil',
                            type: 'success',
                            padding: '2em'
                        })
                    </script>
                ");
            } else {
                return redirect('/')->with('pesan', "
                    <script>
                        swal({
                            title: 'Login Failed!',
                            text: 'Password salah',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }
        }

        $instruktur = Instruktur::firstWhere('email', $request->input('email'));
        if ($instruktur) {

            if ($instruktur->is_active == 0) {
                return redirect('/')->with('pesan', "
                    <script>
                        swal({
                            title: 'Login Failed!',
                            text: 'akun tidak aktif',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }

            if (Hash::check($request->input('password'), $instruktur->password)) {
                $request->session()->put('id', $instruktur->id);
                $request->session()->put('email', $instruktur->email);
                $request->session()->put('nama_instruktur', $instruktur->nama_instruktur);
                $request->session()->put('role', 2);
                return redirect()->intended('/instruktur')->with('pesan', "
                    <script>
                        swal({
                            title: 'Berhasil!',
                            text: 'login berhasil',
                            type: 'success',
                            padding: '2em'
                        })
                    </script>
                ");
            } else {
                return redirect('/')->with('pesan', "
                    <script>
                        swal({
                            title: 'Login Failed!',
                            text: 'Password salah',
                            type: 'error',
                            padding: '2em'
                        })
                    </script>
                ");
            }
        }
    }

    public function install()
    {
        $admin = Admin::all();
        if ($admin->count() != 0) {
            return redirect('/')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: 'Akun admin sudah dibuat',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ");
        }

        return view('auth.install', [
            "title" => "Installasi Admin"
        ]);
    }
    public function install_(Request $request)
    {
        $validate = $request->validate([
            'nama_admin' => 'required',
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $validate['password'] = Hash::make($validate['password']);
        Admin::create($validate);
        return redirect('/')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'Akun admin berhasil dibuat',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function aktivasi(Token $token)
    {
        if ($token->created_at->diffInMinutes() > 60) {

            if ($token->role == 2) {
                Instruktur::where('email', $token->email)
                    ->delete();
            } else {
                Peserta::where('email', $token->email)
                    ->delete();
            }
            Token::where('id', $token->id)
                ->delete();

            return redirect('/')->with('pesan', "
                <script>
                    swal({
                        title: 'Token Expired!',
                        text: 'token sudah kadaluarsa, silahkan lakukan daftar ulang',
                        type: 'warning',
                        padding: '2em'
                    })
                </script>
            ");
        }

        if ($token->role == 2) {
            Instruktur::where('email', $token->email)
                ->update(['is_active' => 1]);
        } else {
            Peserta::where('email', $token->email)
                ->update(['is_active' => 1]);
        }

        Token::where('id', $token->id)
            ->delete();

        return redirect('/')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'Akun sudah aktif, silahkan login',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function recovery()
    {
        $admin = Admin::all();
        if ($admin->count() == 0) {
            return redirect('/')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: 'Akun admin belum dibuat',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ");
        }

        return view('auth.recovery', [
            'title' => 'Lupa Password'
        ]);
    }
    public function recovery_(Request $request)
    {
        $user = null;
        $admin = Admin::firstWhere('email', $request->input('email'));
        if ($admin) {
            $user = $admin;
        }
        $instruktur = Instruktur::firstWhere('email', $request->input('email'));
        if ($instruktur) {
            $user = $instruktur;
        }
        // $peserta = Peserta::firstWhere('email', $request->input('email'));
        // if ($peserta) {
        //     $user = $peserta;
        // }

        if ($user == null) {
            return redirect('/recovery')->with('pesan', "
                <script>
                    swal({
                        title: 'Error!',
                        text: 'email tidak ditemukan, silahkan coba lagi',
                        type: 'error',
                        padding: '2em'
                    })
                </script>
            ");
        }

        $tokens = [
            'token' => Str::random(40),
            'email' => $request->email,
            'key' => 'password',
            'role' => $user->role
        ];
        $details = [
            'email' => $request->email,
            'token' => $tokens['token']
        ];
        Mail::to("$request->email")->send(new ForgotPassword($details));
        Token::create($tokens);

        return redirect('/')->with('pesan', "
                <script>
                    swal({
                        title: 'Berhasil!',
                        text: 'silahkan buka email untuk validasi lupa password',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
    }
    public function change_password(Token $token)
    {
        if ($token->created_at->diffInMinutes() > 60) {
            Token::where('id', $token->id)
                ->delete();

            return redirect('/')->with('pesan', "
                <script>
                    swal({
                        title: 'Token Expired!',
                        text: 'token sudah kadaluarsa, silahkan ulangi proses',
                        type: 'warning',
                        padding: '2em'
                    })
                </script>
            ");
        }

        return view('auth.change-password', [
            'token' => $token
        ]);
    }
    public function change_password_(Token $token, Request $request)
    {
        $password = bcrypt($request->password);
        if ($token->role == 1) {
            Admin::where('email', $token->email)
                ->update(['password' => $password]);
        }
        if ($token->role == 2) {
            Instruktur::where('email', $token->email)
                ->update(['password' => $password]);
        }
        if ($token->role == 3) {
            Peserta::where('email', $token->email)
                ->update(['password' => $password]);
        }
        Token::where('id', $token->id)
            ->delete();

        return redirect('/')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'password telah di ubah, silahkan login',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    public function logout(Request $request)
    {
        $request->session()->remove('id');
        $request->session()->remove('email');
        $request->session()->remove('role');

        return redirect('/')->with('pesan', "
            <script>
                swal({
                    title: 'Berhasil!',
                    text: 'Anda telah logout',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");

        return redirect('/');
    }
}
