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
                <div class="well" style="margin-top:50px;padding-left: 39%;height: 100vh;">
                <div class="col-md-6">

                    <form action="{{route('staff.update')}}" method="post">{{csrf_field()}}
                    <div class="image-rounded">
                        <center><img class="img-circle" style="width:100px;" src="https://png.pngtree.com/png-vector/20220709/ourmid/pngtree-businessman-user-avatar-wearing-suit-with-red-tie-png-image_5809521.png" alt="">
                     <div class="name-login">
                         <h4 style="color:#929292">{{$data->username}}</h4>

                         <h5 style="color:#929292">{{$data->position}}</h5>
                     </div>
                     </center>
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="NAME" value="{{$data->name}}" name="name" required>
                        <input type="hidden" value="{{$data->id}}" name="id" required>
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="POSISITON" value="{{$data->position}}" name="position" required>

                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="STUFF ID" value="{{$data->stuff_id}}" name="stuff_id" required>

                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="EMAIL" value="{{$data->email}}" name="email" required>

                      </div>
                      <div class="form-group">
                        <button style="width:100%" class="btn btn-primary">UPDATE</button>

                      </div>
                      </form>

                </div>
                </div>









            </div>
        </div>
    </div>
@endsection
