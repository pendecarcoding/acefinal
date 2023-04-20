<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STAFF|LOGIN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .input-container {
      position: relative;
    }
        /* Style for the icon */
    .input-container::before {
      content: "\f007"; /* FontAwesome icon code for user */
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
                    <div class="mb-5 text-center">
                        <img src="{{ uploaded_asset(get_setting('site_icon')) }}"
                            class="mw-100 mb-4" height="100">
                        <h1 style="color: #6d6d6d;font-size: 20px;" class="h3  mb-0">Staff Login</h1>
                        @include('acewebfront.pages.alert')
                    </div>
                    <form class="pad-hor" method="POST" role="form" action="{{route('staff.login')}}">
                        {{csrf_field()}}
                        <div style="margin-left: 20px;margin-right: 20px;">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span style="height: 40px;
                                  border-radius: 0px;" class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-user"></i></span>
                                </div>
                                <input required name="username" type="text" class="form-control" placeholder="Username" aria-label="Username"
                                    aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span style="height: 40px;
                                  border-radius: 0px;" class="input-group-text" id="basic-addon1"><i
                                            class="fa fa-lock"></i></span>
                                </div>
                                <input id="password" type="password" class="form-control" name="password" required=""
                                    placeholder="Password">
                            </div>
                        </div>

                        <div class="row mb-2">

                        </div>
                        <div class="form-group">
                            <button style="width:100%;background-color: #264e77;border: #264e77;" type="submit"
                                class="btn btn-primary btn-lg btn-block">
                                LOGIN
                            </button>
                            <br>
                            <center>
                                <p style="margin-top: 5px;color:#959595">Don't have an account? <span><a style="color:#959595;text-decoration: none;"
                                            href="{{ url('registerstaff') }}">Create
                                            account</a></span></p>

                                <p><span><a style="color:#959595;text-decoration: none;"
                                    href="{{ url('forgotpass') }}">Forgot Password</a></span></p>
                            </center>

                        </div>
                    </form>

                </div>
            </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
