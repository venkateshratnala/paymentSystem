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
        <h2 style="  text-align: justify;  text-justify: inter-word;">Sign Up</h2><br>
        <form id="signupform" action="#" method="post" autocomplete="off">
            @csrf
            <label for="fname">First name:</label><br>
            <input type="text" id="fname" name="fname" Placeholder="First Name"><br>
            <label for="lname">Last name:</label><br>
            <input type="text" id="lname" name="lname" placeholder="Last Name"><br>
            <label for="phone">Phone:</label><br>
            <input type="tel" id="phone" name="mobile_no" Placeholder="Phone"><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="username" Placeholder="Email"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" placeholder="Enter Password"><br>
            <label for="cpassword">Confirm Password:</label><br>
            <input type="cpassword" id="cpassword" name="password_confirm" placeholder="Confirm Password"><br>

            {{-- <input type="submit" id="submit" name="submit" value="Sign Up"> --}}
            <button type="button" id="submitform" class="btn btn-primary btn-block">Sign Up</button>
        </form>
    </div>




    @extends('footer')
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>


    <script>
        $(function() {
            $("#submitform").click(function() {
                var formData = new FormData($('#signupform')[0]);
                formData.append("_token", "{{ csrf_token() }}");
                $('.error').html('');
                $('.error-message').html('');
                $('#submitform').attr('disabled', 'disabled').text('signing up...');
                $.ajax({
                    url: '{{ url('doSignUp') }}',
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    async: false,
                    success: function(data) {
                        if (data.status) {
                            swal({
                                title: "Done!",
                                text: data.message,
                                type: "success"
                            }, function(isConfirm) {
                                if (isConfirm) {
                                    window.location.href = data.redirect_url;
                                }
                            });
                        } else {
                            // reload_captcha();
                            $('.error-message').html(data.message);
                            $('#submitform').removeAttr('disabled').text('Sign Up');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#submitform').removeAttr('disabled').text('Sign Up');
                        $.each(jqXHR.responseJSON.errors, function(key, value) {
                            $('#signupform [name="' + key + '"]').next().html(value);
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
</body>

</html>
