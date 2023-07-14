<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap 5 Website Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .fakeimg {
            height: 200px;
            background: #aaa;
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
    <div class="col-md-12 login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">User Profile</div>
                        <div class="card-body" id="profile_form">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Full
                                    Name</label>
                                <div class="col-md-6">
                                   
                                    <input type="text" id="name" class="form-control" name="name"
                                        value="{{ $userData->fname . ' ' . $userData->lname }}" required autofocus>
                                    <span class="error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">Phone No</label>
                                <div class="col-md-6">
                                    <input type="text" id="mobile_number" value="{{ $userData->mobile_no }}"
                                        class="form-control" name="mobile_number" required maxlength="10"
                                        onkeypress="return isNumber(event)">
                                    <span class="error"></span>
                                </div>
                            </div>
            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @extends('footer')

</body>

</html>
