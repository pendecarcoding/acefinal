@extends('acewebfront.layouts')
@section('content')
<main>
      <section class="ace-investor">
        <div data-aos="fade-up">
          <div class="col-md-12">
            <div class="banner-static">
              <img
                class="img-responsive-banner newsroom-banner"
                src="https://dev.ace2u.com/public/uploads/all/KHBClZ44puEc2d0r0KQM7yePVBm1OeGK31rmQPnx.jpg"
                alt=""
              />
            </div>
          </div>
        </div>
      </section>

      <section class="gtp-anouncements">
        <div class="content-ace">
          <div class="wrap-content">
            <div style="padding-top: 0px" class="ace-isi about">
              <div class="col-md-12" style="margin-top: 5%">
                <div data-aos="fade-up" class="title-ace">
                 NEWS & EVENTS
                  <span class="h-dash" style="font-weight: bold">—</span>
                </div>
              </div>
              <div data-aos="fade-up" class="col-md-12 col-sm-12">
                <h1>Stay updated with our journey</h1>
              </div>

              <div style="margin-top: 50px" class="row-personals">
                <div class="col-md-9">

                </div>
                <div class="col-md-3">
                  <div class="row-personals">
                    <div style="margin: auto">Sort by:</div>
                    <div style="margin-left: 20px">
                      <select class="form-control">
                        <option value="">Latest</option>
                        <option value="">Oldest</option>
                        <option value="">Popular</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div
                data-aos="fade-up"
                style="margin-top: 40px"
                class="row aos-init aos-animate"
              >
              @foreach($data as $i =>$v)
                <div class="col-md-4">
                  <a href="{{ url('newsroom/'.$v->slug) }}">
                    <img
                      class="img-responsive-news rounded"
                      src="{{ getimage($v->banner) }}"
                      alt=""
                    />
                    <p style="margin-top:18px;margin-bottom: 18px;">{{ $v->title }}</p>
                  </a>
                </div>
            @endforeach

              </div>
              <div style="margin-top: 20px;" class="row">
                <div class="container">
                    <div class="col-md-12">

                        <div class="d-flex justify-content-center">
                           {!! $data->links() !!}
                       </div>
                   </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
@endsection
