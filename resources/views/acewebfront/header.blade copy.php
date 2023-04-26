<header>
    <nav id="myTopnav" class="topnav" @if(Session::get('loginstaff')==true) style="left: 19%;" @endif>
        @foreach (getnav() as $v)
            <a href="{{ url($v['link']) }}"
                @if (Request::is($v['link'] . '*')) class="active" @endif>{{ $v['name'] }}</a>
        @endforeach
        @if(Session::get('loginstaff')==true)
        <a href="{{ url('staff/back/announcements') }}"
                @if (Request::is('staff/back/announcements')) class="active" @endif>Staff</a>
        @endif


        <!-- Create div with dropdown-menu class and ID that matches data-bs-target attribute on button -->
        @if(Session::get('loginstaff')==true)

        <a onclick="logoutFunction()" style="font-size:28px;color:white"><i class="fa fa-sign-out" aria-hidden="true"></i></a>

        @else
        <a class="ace-button" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        Login
    </a>
        <div style="overflow: hidden;padding-right: 20px;" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a style="color:black;font-size: 1.38vw;" class="dropdown-item" href="https://gtp.ace2u.com/"
                target="_blank">GTP Login</a>
            <a style="color:black;font-size: 1.38vw;" class="dropdown-item" href="#" style="width:100%;"
                data-bs-toggle="modal" data-bs-target="#exampleModal"> Staff Login</a>

        </div>



        @endif

        <!-- <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Dropdown button
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </div> -->

        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </nav>
</header>

<script>
    function logoutFunction() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "you want to leave this page?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                window.location.href = "{{route('staff.logoutstuff')}}";
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                // swalWithBootstrapButtons.fire(
                //     'Cancelled',
                //     'Your imaginary file is safe :)',
                //     'error'
                // )
            }
        })

    }
</script>
