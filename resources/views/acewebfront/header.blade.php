<header>
      <nav id="myTopnav" class="topnav">
         @foreach(getnav() as $v)
        <a href="{{ url($v['link']) }}" @if(Request::is($v['link'].'*'))class="active"@endif>{{ $v['name'] }}</a>
        @endforeach
        <a style="padding-left: 26px;
        padding-right: 26px;
        padding-top: 2px;
        padding-bottom: 2px;" class="ace-button" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Login
        </a>

          <!-- Create div with dropdown-menu class and ID that matches data-bs-target attribute on button -->
          <div style="overflow: hidden;padding-right: 20px;" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a style="color:black;font-size: 1.38vw;" class="dropdown-item" href="https://gtp.ace2u.com/" target="_blank">GTP Login</a>
            <a style="color:black;font-size: 1.38vw;" class="dropdown-item" href="#" style="width:100%;" data-bs-toggle="modal" data-bs-target="#exampleModal"> Stuff Login</a>

          </div>

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





