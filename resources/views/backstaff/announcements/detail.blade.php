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
                <img style="width:100%;height: 300px;object-fit: cover;" src="{{ static_asset('aceweb') }}/assets/img/sample.png">
                <br>
                <div class="title-announcement">
                    Lorem ipsum dolor sit amet consectetur. Pellentesque nisl auctor nisi viverra. Pellentesque nisl auctor nisi viverra. Pellentesque nisl auctor nisi viverra.
                </div>
                <div class="date-announcement">
                    08/04/2023
                </div>
                <div class="content-announcement">
                    Lorem ipsum dolor sit amet consectetur. Vehicula nibh sapien penatibus sit risus magna pellentesque est euismod. Mi quis erat hac sollicitudin. Est ipsum sed sociis id pellentesque. Malesuada cras amet vestibulum etiam semper. Fusce turpis quis quam in odio est vulputate. Molestie odio at tellus viverra cursus sem cras urna. Phasellus a turpis diam augue semper in feugiat lacus. Nunc senectus pretium malesuada cursus nibh. Metus vel cum vitae congue quam diam lacus neque pellentesque. Orci mi consectetur cras tempus. Ullamcorper tincidunt lobortis fames varius.
In sed eu ac adipiscing at blandit in leo. Amet nec rhoncus ornare porttitor accumsan ut at blandit ipsum. Non accumsan vivamus nunc blandit sit. Elementum id eu dictum eleifend cursus commodo viverra nisi. Cursus viverra nisl amet nisl. Bibendum sit vel enim placerat dictumst eget. Phasellus sollicitudin in adipiscing arcu enim. Sodales leo quis iaculis euismod commodo. Lectus eget suscipit viverra iaculis eu venenatis. Congue vitae magna et at libero. Et purus diam dictum mi adipiscing donec. Nec pharetra ac duis urna hendrerit odio venenatis. Iaculis tortor elementum morbi a suspendisse. Velit ullamcorper egestas ut sed.
Est lectus ut at netus pharetra lacus. Arcu volutpat enim at in. Eu dolor a ac laoreet arcu lectus diam mi amet. Diam nulla amet sed pharetra in eget diam. At pretium scelerisque dolor volutpat quam id erat. Orci in proin dolor consequat.
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
