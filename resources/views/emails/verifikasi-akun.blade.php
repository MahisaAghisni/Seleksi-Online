<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Akun</title>
</head>
<body>
    <div style="padding: 10px;">
        <div style="font-family: `Segoe UI`, Tahoma, Geneva, Verdana, sans-serif; font-size: 20px; color: #1C3FAA; font-weight: bold;">
        CBT Malela
        </div>
        <small style="color: #000;">cbtmalela laravel-8 | by Abduloh</small>
        <p style="font-family: `Segoe UI`, Tahoma, Geneva, Verdana, sans-serif; color: #000;">
            Halo {{ $details['nama'] }}, kamu telah mendaftar kedalam aplikasi CBT MALELA. berikut merupakan informasi akunmu :
        </p>
        <table style="font-family: `Segoe UI`, Tahoma, Geneva, Verdana, sans-serif; color: #000;">
            <tr>
                <td>NAMA</td>
                <td> : {{ $details['nama'] }}</td>
            </tr>
            <tr>
                <td>EMAIL</td>
                <td> : {{ $details['email'] }}</td>
            </tr>
            <tr>
                <td>PASSWORD</td>
                <td> : {{ $details['password'] }}</td>
            </tr>
        </table>
        <p style="font-family: `Segoe UI`, Tahoma, Geneva, Verdana, sans-serif; color: #000;">
            silahkan klik tombol dibawah ini untuk mengaktifkan akunmu, jika tombol tidak bisa di klik silahkan copy link di bawah kemudian tempelkan di browser anda
        </p>
        <a href="{{ url('/aktivasi/' . $details['token']) }}" style="display: inline-block; width: 100px; height: 30px; background: #1C3FAA; color: #fff; text-decoration: none; border-radius: 5px; text-align: center; line-height: 30px; font-family: `Segoe UI`, Tahoma, Geneva, Verdana, sans-serif;">
            Aktivasi
        </a>
        <br>
        <br>
        <a href="{{ url('/aktivasi/' . $details['token']) }}">
            {{ url('/aktivasi/' . $details['token']) }}
        </a>
    </div> 
</body>
</html>