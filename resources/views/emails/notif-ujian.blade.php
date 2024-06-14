<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ujian</title>
</head>

<body>
    <div style="padding: 10px;">
        <div
            style="font-family: `Segoe UI`, Tahoma, Geneva, Verdana, sans-serif; font-size: 20px; color: #1C3FAA; font-weight: bold;">
            CBT Malela
        </div>
        <small style="color: #000;">cbtmalela laravel-8 | by Abduloh</small>
        <p style="font-family: `Segoe UI`, Tahoma, Geneva, Verdana, sans-serif; color: #000;">
            Halo para siswa, {{ $details['nama_guru'] }} telah memposting Ujian baru :
        </p>
        <table style="font-family: `Segoe UI`, Tahoma, Geneva, Verdana, sans-serif; color: #000;">
            <tr>
                <td>Ujian</td>
                <td> : {{ $details['nama_ujian'] }}</td>
            </tr>
            <tr>
                <td>Waktu Ujian</td>
                <td> : {{ $details['jam'] }} Jam {{ $details['menit'] }} Menit</td>
            </tr>
        </table>
        <p style="font-family: `Segoe UI`, Tahoma, Geneva, Verdana, sans-serif; color: #000;">
            silahkan login untuk mengerjakan ujian
        </p>
        <a href="{{ url('/') }}"
            style="display: inline-block; width: 100px; height: 30px; background: #1C3FAA; color: #fff; text-decoration: none; border-radius: 5px; text-align: center; line-height: 30px; font-family: `Segoe UI`, Tahoma, Geneva, Verdana, sans-serif;">
            Login
        </a>
    </div>
</body>

</html>
