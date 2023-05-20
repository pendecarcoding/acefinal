@extends('acewebfront.layouts')
@section('content')
<main>
      <section class="ace-investor">

          <div class="col-md-12">
            <div class="banner-static">
              <img
              class="img-responsive-banner"
                src="{{ asset('public/uploads') }}/all/ySFIbEbUUtgi6okRteLoDLH71K9faQfB3X5nKqCZ.jpg"
                alt="ACE-BANNER-PRODUCT"
              />
            </div>
        </div>
      </section>

      <section style="background-color:rgb(29 81 137);" class="gtp-anouncements">
        <div class="content-ace">
          <div class="wrap-content" style="padding: 50px;">
            <div class="col-md-4">
             <div>
                <h2 style="color:white"><b>Tracking Your Order</b></h2>
                <div style="display: flex;justify-content: space-around;">
                    <input type="text" class="form-control">
                    <button style="margin-left:10px" class="btn btn-danger">Tracking</button>
                </div>

             </div>
            </div>

          </div>
        </div>

      </section>


 

    </main>

@endsection
