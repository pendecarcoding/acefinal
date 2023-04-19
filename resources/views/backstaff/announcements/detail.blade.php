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

            <div class="well" style="margin-top:50px">
                @if($data->image != null)
                <img style="width:100%;height: 300px;object-fit: cover;" src="{{ getimage($data->image) }}">
                @endif
                <br>
                <div class="title-announcement">
                    {{$data->title}}
                </div>
                <div class="date-announcement">
                    {{$data->created_at}}
                </div>
                <div class="content-announcement">
                    {!! $data->description !!}
                </div>
                <div class="fotter-announcement">
                    <a class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                    <a class="btn btn-primary"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                </div>


                </div>







        </div>
    </div>
    </div>
    @endsection
