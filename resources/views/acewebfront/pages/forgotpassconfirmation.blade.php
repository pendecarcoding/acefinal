<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STAFF|FORGOT PASSWORD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .input-container {
            position: relative;
        }

        /* Style for the icon */
        .input-container::before {
            content: "\f007";
            /* FontAwesome icon code for user */
            font-family: FontAwesome;
            position: absolute;
            left: 10px;
            top: 8px;
            font-size: 18px;
            color: #ccc;
        }
    </style>
    <script src="https://use.fontawesome.com/87a11cdc5f.js"></script>
</head>

<body>
    <div class="container" style="
    margin-top: 4%;
">
        <div class="row">
            <div class="col-lg-6 col-xl-6 mx-auto">
                <div class="text-left">
                    <div class="card-body">
                        <div class="mb-5 text-center">
                            <img src="{{ uploaded_asset(get_setting('site_icon')) }}" class="mw-100 mb-4"
                                height="100">
                            <h1 class="h3 mb-0" style="color:#1D5189;font-weight: bold;">Forgot Password</h1>
                            @include('acewebfront.pages.alert')
                        </div>
                        <form class="pad-hor" method="POST" role="form" action="{{route('staff.resetconfir')}}">
                            {{csrf_field()}}

                            <div class="input-group mb-3">
                                <input type="hidden" name="reset_code" value={{$code}}>
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock-o"
                                            aria-hidden="true"></i></span>
                                </div>
                                <input id="password" type="password" class="form-control" name="pass1" required=""
                                    placeholder="Password">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"
                                            aria-hidden="true"></i></span>
                                </div>
                                <input id="password" type="password" class="form-control" name="pass2" required=""
                                    placeholder="Re Password">
                            </div>

                            <button style="background-color:#1D5189;border-color:#1D5189 ;" type="submit"
                                class="btn btn-primary btn-lg btn-block">
                                CONFIRM
                            </button>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
