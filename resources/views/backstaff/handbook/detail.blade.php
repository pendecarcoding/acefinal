@extends('backstaff.layouts')
@section('content')
    <div class="container-fluid">
        <div class="row content" style="display: flex;">
            @include('backstaff.sidebar')


            <br>




            <div class="col-sm-9" style="    margin-left: 19%;
        width: 100%;display: flex;flex-direction: column;">
                <div class="well"
                    style="    top: 0;
            padding: 7px;
            display: flex;
            justify-content: space-around;
            position: fixed;
            width: -webkit-fill-available;z-index: 1;">
                    <input type="text" class="form-control" placeholder="Announcement"><span><button
                            class="btn btn-primary">SEARCH</button></span>

                </div>

                <div class="well" style="margin-top:50px">
                    <embed src="https://dev.ace2u.com/public/uploads/all/heeL4Nh2Ce6OQt6hJBF0SrRQQn6hSTGG8rJqWdNt.pdf"
                        style="width:100%;height: 85vh;" type="application/pdf">


                </div>







            </div>
        </div>
    </div>
@endsection
