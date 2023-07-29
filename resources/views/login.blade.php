<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap 5 Website Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        input,
        select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            width: 100%;
            background-color: #2e2d4c;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <div class=" bg-primary text-white ">
        <div class="col-sm-12 " style="height:50px;">
            <h2 class="allign-start">Logo </h2>
        </div>
    </div>

    @include('header')

    <div style="background:#efefef; color:#000; width:500px; margin: auto; margin-top:50px; padding: 50px;">
        <h2 style="  text-align: justify;  text-justify: inter-word;">Login</h2><br>
        <form id="loginform" action="#" method="post" autocomplete="off">
            @csrf
            <input type="hidden" name="pid" value="{{ isset($pid) ? $pid : '' }}">
            <input type="hidden" name="requestId" value="{{ isset($requestId) ? $requestId : '' }}">
            <input type="hidden" name="isReturn" value="{{ isset($isReturn) ? $isReturn : '' }}">
            <label for="email">Email:</label><br>
            <input type="email" name="username" id="email" Placeholder="Email"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" placeholder="Enter Password"><br>
            {{-- <input type="submit" id="submit" name="submit" value="Login"> --}}
            <button type="button" id="submitform" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>

    <style type="text/css">
        .login-box,
        .register-box {
            width: 420px;
        }
    </style>

    <div class="login-box" style="margin-top:10px;">
        <div class="card">
            <div class="card-body login-card-body">
                <div class="login-logo ">
                    <a href="{{ url('/') }}">
                        <img src="@asset('img/adminlogo.png')" alt="" style="width:80%" class="img-fluid">
                    </a>
                </div>

                <p class="login-box-msg text-center">
                    Sign in to start your session</p>
                @error('pass')
                    <p class="help-block">{{ $message }}</p>
                @enderror
                <form id="loginform" action="#" method="post" autocomplete="off">
                    @csrf
                    <div class="input-group mb-3">
                        {{-- <input type="hidden" name="pid"  value="{{isset($pid)?$pid:''}}">
                        <input type="hidden" name="requestId"  value="{{isset($requestId)?$requestId:''}}">
                        <input type="hidden" name="isReturn"  value="{{isset($isReturn)?$isReturn:''}}"> --}}
                        <input type="email" class="form-control" placeholder="UserName" required maxlength="100"
                            name="username" autocomplete="off">
                        <span class="error"></span>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" required maxlength="100"
                            name="password" autocomplete="off">
                        <span class="error"></span>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <span class="error-message"></span>
                        </div>
                    </div>
                    <div class="row mb-4" style="padding-left:15px">
                        <div class="form-group mb-2">
                            <div class="captcha">
                                {{-- <span>{!! captcha_img() !!}</span> --}}
                                <button type="button" class="btn btn-danger" class="reload" id="reload">
                                    &#x21bb;
                                </button>
                            </div>
                        </div><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <div class="input-group-append mb-2">
                            <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha"
                                name="captcha" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group mb-3">
                            <button type="button" id="submitform" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>

                <p class="mt-1">
                </p>
                @if (env('APP_ENV') != 'local')
                    <p class="mt-1">
                        <a href="{{ url('/forgot-password') }}" class="btn btn-link"
                            title="Click here to reset your password">
                            Forgot Your Password?
                        </a>
                    </p>
                @endif
                <hr>
                <div class="row">
                    <div class="col-8">
                        <a href="{{ url('/user/sign_up') }}" class="btn btn-link"
                            title="Click here to reset your password">
                            Create an User Account? </a>
                    </div>
                    <div class="col-4">
                        <a href="{{ URL::to('/user/sign_up') }}" target="_blank" class="btn btn-success btn-block"
                            type="button">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .swal2-close {
            background-color: red;
        }
    </style>

    {{-- <script src="@asset('plugins/jquery/jquery.js')"></script> --}}
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            $("#submitform").click(function() {
                var formData = new FormData($('#loginform')[0]);
                formData.append("_token", "{{ csrf_token() }}");
                $('.error').html('');
                $('.error-message').html('');
                $('#submitform').attr('disabled', 'disabled').text('Logging..');
                $.ajax({
                    url: '{{ url('doLogin') }}',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    async: false,
                    success: function(data) {
                        var APP_URL = {!! json_encode(url('/')) !!};
                        if (data.status) {
                            window.location.replace(APP_URL + data.redirect);
                        } else {
                            // reload_captcha();
                            $('.error-message').html(data.message);
                            $('#submitform').removeAttr('disabled').text('Sign In');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#submitform').removeAttr('disabled').text('Sign In');
                        $.each(jqXHR.responseJSON.errors, function(key, value) {
                            $('#loginform [name="' + key + '"]').next().html(value);
                        });
                        // reload_captcha();
                        $('.error-message').html('Entered Wrong Captcha');
                    }
                });
            });
            $('#reload').click(function() {
                reload_captcha();
            });
        });

        function reload_captcha() {
            $.ajax({
                type: 'GET',
                url: '{{ url('admin/reload-captcha') }}',
                success: function(data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        }
    </script>

    <style>
        .error {

            font-size: 12px;
        }

        .login-card-body .input-group {
            position: relative;
        }

        .login-card-body .input-group .error {
            position: absolute;
            bottom: -18px;
            color: #ff0000;
        }

        .error-message {
            color: #ff0000;
        }
    </style>
    @include('footer')

</body>

</html>
