<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Ubah Password</title>
    <link rel="icon" type="image/x-icon" href="{{ url('/assets/img') }}/logoblk.png" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="{{ url('/assets/template') }}/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/assets/template') }}/assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="{{ url('/assets/template') }}/assets/css/authentication/form-2.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css"
        href="{{ url('/assets/template') }}/assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="{{ url('/assets/template') }}/assets/css/forms/switches.css">
    <script src="{{ url('/assets/template') }}/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="{{ url('/assets/template') }}/plugins/sweetalerts/sweetalert2.min.js"></script>
    <script src="{{ url('/assets/template') }}/plugins/sweetalerts/custom-sweetalert.js"></script>
</head>

<body class="form no-image-content">
    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">

                        <h1 class="">Password Recovery</h1>
                        <p class="signup-link recovery">silahkan masukkan password baru kamu</p>
                        <form action="{{ url('/change_password/' . $token->token) }}" method="post" class="text-left">
                            @csrf
                            <div class="form">
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">NEW PASSWORD</label>
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2">
                                        </rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="password" name="password" type="password" class="form-control"
                                        placeholder="Password" required>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" id="toggle-password"
                                        class="feather feather-eye">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PAGE SCRIPT -->
    <script src="{{ url('/assets/template') }}/assets/js/authentication/form-2.js"></script>

</body>

</html>
