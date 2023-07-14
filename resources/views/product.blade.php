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

    <div id="product" style="width:100%; background:red;">
        <div id="price">

        </div>
        <div id="price">

        </div>
        <div id="price">

        </div>
    </div>
    <main style="width:60%; margin:auto; margin-top:50px;">
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3 text-bg-primary border-primary">
                        <h4 class="my-0 fw-normal">Basic</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">$0<small
                                class="text-body-secondary fw-light">/mo</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>1st Service</li>
                            <li>2nd Service</li>
                            <li>3rd Service</li>
                            <li>4th Service</li>
                        </ul>
                        <button type="button" class="w-100 btn btn-lg btn-primary">Start Free Trail</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm">
                    <div class="card-header py-3 text-bg-primary border-primary">
                        <h4 class="my-0 fw-normal">Standard</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">$15<small
                                class="text-body-secondary fw-light">/mo</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>1st Service</li>
                            <li>2nd Service</li>
                            <li>3rd Service</li>
                            <li>4th Service</li>
                        </ul>
                        <button type="button" class="w-100 btn btn-lg btn-primary">Start Free Trail</button>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-4 rounded-3 shadow-sm border-primary">
                    <div class="card-header py-3 text-bg-primary border-primary">
                        <h4 class="my-0 fw-normal">Premium</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">$29<small
                                class="text-body-secondary fw-light">/mo</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>1st Service</li>
                            <li>2nd Service</li>
                            <li>3rd Service</li>
                            <li>4th Service</li>
                        </ul>
                        <button type="button" class="w-100 btn btn-lg btn-primary">Start Free Trail</button>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="display-6 text-center mb-4">Compare plans</h2>

        <div class="table-responsive">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th style="width: 34%;"></th>
                        <th style="width: 22%;">Basic</th>
                        <th style="width: 22%;">Standard</th>
                        <th style="width: 22%;">Premium</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" class="text-start">Public</th>
                        <td><svg class="bi" width="24" height="24">
                                <use xlink:href="#check" />
                            </svg></td>
                        <td><svg class="bi" width="24" height="24">
                                <use xlink:href="#check" />
                            </svg></td>
                        <td><svg class="bi" width="24" height="24">
                                <use xlink:href="#check" />
                            </svg></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-start">Service 1</th>
                        <td></td>
                        <td><svg class="bi" width="24" height="24">
                                <use xlink:href="#check" />
                            </svg></td>
                        <td><svg class="bi" width="24" height="24">
                                <use xlink:href="#check" />
                            </svg></td>
                    </tr>
                </tbody>

                <tbody>
                    <tr>
                        <th scope="row" class="text-start">Service 2</th>
                        <td><svg class="bi" width="24" height="24">
                                <use xlink:href="#check" />
                            </svg></td>
                        <td><svg class="bi" width="24" height="24">
                                <use xlink:href="#check" />
                            </svg></td>
                        <td><svg class="bi" width="24" height="24">
                                <use xlink:href="#check" />
                            </svg></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-start">Service 3</th>
                        <td></td>
                        <td><svg class="bi" width="24" height="24">
                                <use xlink:href="#check" />
                            </svg></td>
                        <td><svg class="bi" width="24" height="24">
                                <use xlink:href="#check" />
                            </svg></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-start">Service 4</th>
                        <td></td>
                        <td><svg class="bi" width="24" height="24">
                                <use xlink:href="#check" />
                            </svg></td>
                        <td><svg class="bi" width="24" height="24">
                                <use xlink:href="#check" />
                            </svg></td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-start">Service 5</th>
                        <td></td>
                        <td></td>
                        <td><svg class="bi" width="24" height="24">
                                <use xlink:href="#check" />
                            </svg></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
    @include('footer')

</body>

</html>
