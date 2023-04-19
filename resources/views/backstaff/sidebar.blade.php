 <?php
 use App\Models\Stuff;
 $data = Stuff::where('id',session()->get('id_staff'))->first();

 ?>
 <div class="col-sm-3 sidenav hidden-xs"
     style="background-color: #FFFFFF80;position: fixed!important;
             z-index: 1;
             width: 19%;;
             padding: 36px;
             overflow: auto;">
     <div class="image-rounded">
       <center>

       <!-- <img class="img-circle" style="width:100px;" src="https://png.pngtree.com/png-vector/20220709/ourmid/pngtree-businessman-user-avatar-wearing-suit-with-red-tie-png-image_5809521.png" alt="">
     -->
       <div class="name-login">
        <h4 style="color:#929292">{{$data['username']}}</h4>

        <h5 style="color:#929292">{{$data['position']}}</h5>
    </div>
    </center>
     </div>
     <ul class="nav nav-pills nav-stacked" style="margin-top: 50px;">
         <li class="active"><a href="{{route('staff.announcements')}}"><i class="fa fa-bell" aria-hidden="true"></i> Announcement</a></li>
         <li><a href="{{route('staff.handbook')}}"><i class="fa fa-book" aria-hidden="true"></i> Employee Handbook</a></li>

     </ul><br>
     <div style="position: fixed;bottom: 0;">
        <ul class="nav nav-pills nav-stacked" style="margin-top: 50px;">
            <li><a href="{{route('staff.setting')}}"><i class="fa fa-user" aria-hidden="true"></i> Profile</a></li>
            <li><a href="#" onclick="logoutFunction()"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a></li>

        </ul>
     </div>
 </div>


