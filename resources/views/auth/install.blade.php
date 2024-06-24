<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>BLK Sumenep</title>
    <link rel="icon" type="image/x-icon" href="{{ url('/assets/img') }}/logoblk.png" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="{{ url('/assets/template') }}/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/assets/template') }}/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/assets/template') }}/assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css"
        href="{{ url('/assets/template') }}/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/assets/template') }}/assets/css/forms/switches.css">
    <link href="{{ url('/assets/template') }}/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet"
        type="text/css" />
    <link href="{{ url('/assets/template') }}/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="{{ url('/assets/template') }}/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="{{ url('/assets/template') }}/plugins/sweetalerts/sweetalert2.min.js"></script>
    <script src="{{ url('/assets/template') }}/plugins/sweetalerts/custom-sweetalert.js"></script>
</head>

<body class="form "
    style="background-image: url('https://blksumenep.com//assets/img/blk.jpg'); background-size: cover;">
    <div class="form-form ">
        <div class="">
            <div class="form-form-wrap my-auto ">
                <div class="d-flex justify-content-center p-5 rounded-lg "
                    style="background-color: rgba(255, 255, 255, 0.8);">
                    <div class="form-content ">
                        <h1 class="">Buat Akun Admin</h1>
                        <form action="{{ url('/install') }}" method="POST" class="text-left">
                            <div class="form">
                                @csrf
                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input type="text" id="username" name="nama_admin"
                                        value="{{ old('nama_admin') }}" type="text"
                                        class="form-control  @error('nama_admin') is-invalid @enderror"
                                        placeholder="Nama Admin" required autocomplete="off">
                                    @error('nama_admin')
                                        <div class="invalid-feedback" style="display: block;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div id="email-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-at-sign">
                                        <circle cx="12" cy="12" r="4"></circle>
                                        <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>
                                    </svg>
                                    <input type="email" id="email" name="email" type="text"
                                        class=" @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                        placeholder="Email" required autocomplete="off">
                                    @error('email')
                                        <div class="invalid-feedback" style="display: block;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2"
                                            ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input type="password" id="password"
                                        class=" @error('password') is-invalid @enderror" name="password"
                                        type="password" value="" placeholder="Password" required>
                                    @error('password')
                                        <div class="invalid-feedback" style="display: block;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper toggle-pass">
                                        <p class="d-inline-block">Show Password</p>
                                        <label class="switch s-primary">
                                            <input type="checkbox" id="toggle-password" class="d-none">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Buat</button>
                                    </div>
                                </div>
                            </div>
                        </form><br>
                        <p class="terms-conditions" style="margin-top: 30px;">Copyright © 2024 by <a
                                href="https://blksumenep.com/" target="_blank">BLK Sumenep</a> All
                            rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ url('/assets/template') }}/bootstrap/js/popper.min.js"></script>
    <script src="{{ url('/assets/template') }}/bootstrap/js/bootstrap.min.js"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ url('/assets/template') }}/assets/js/authentication/form-1.js"></script>

    {!! session('pesan') !!}
</body>

</html>
