@extends('backstaff.layouts')
@section('content')
<div class="container-fluid">
        <div class="row content" style="display: flex;">
            @include('backstaff.sidebar')


            <br>




        <div class="col-sm-9" style="    margin-left: 19%;
        width: 100%;display: flex;flex-direction: column;">
            <div class="well" style="    top: 0;
            padding: 7px;
            display: flex;
            justify-content: space-around;
            position: fixed;
            width: -webkit-fill-available;z-index: 1;">
                <input type="text" class="form-control" placeholder="Announcement"><span><button class="btn btn-primary">SEARCH</button></span>

            </div>

            <div class="well" style="margin-top:50px;height: 100vh;">
                <h2 style="font-weight: bold;color:#1D5189">Announcement</h2>
                <br>
                @foreach($announce as $i =>$v)
                <div class="list-content">
                  <a style="text-decoration: none;" href="{{route('staff.detailannouncements',base64_encode($v->id))}}">
                    <p>{{$v->title}}</p>
                    <p style="color:#1D5189">{{$v->created_at}}</p>
                    <hr style="border: 1px solid #b1b0b0;">
                  </a>
                </div>
                @endforeach

                </div>







        </div>
    </div>
    </div>
    @endsection
