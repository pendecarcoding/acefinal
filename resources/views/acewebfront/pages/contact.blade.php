 @extends('acewebfront.layouts')
 @section('meta')
      <meta property="og:image" content="{{ uploaded_asset(get_setting('system_logo_white')) }}" />
 @endsection
 @section('content')
     <main>
         <section class="ace-investor">
             <div data-aos="fade-up">
                 <div class="col-md-12">
                     <div class="banner-static">
                         <img class="img-responsive-banner" src="/public/aceweb/assets/img/contact-banner.jpg"
                             alt="ACE-BANNER-CONTACT" />
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
                                 STAY CONNECTED
                                 <span class="h-dash" style="font-weight: bold">—</span>
                             </div>
                         </div>
                         <div data-aos="fade-up" class="col-md-12 col-sm-12">
                             <h1>We’d love to hear from you</h1>
                         </div>

                         @if($hQContact != null)
                         <div style="margin-top: 50px" class="row">
                             <div class="col-md-6">
                                 <div class="contact-wrap">
                                     <img class="img-responsive" src="{{ asset('public/' .$contact->getImage->file_name) }}"
                                         alt="" />
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="contact-wrap">
                                     <div class="list-contact">
                                         <h5 class="title-corporate">{{$hQContact->name}}</h5>
                                         <br>
                                         <p style="font-weight: bold">Address</p>

                                         <p><a style="color:#999999" href="{{$hQContact->link}}">
                                            {{$hQContact->address}}
                                          </a>
                                         <br>
                                         @if($hQContact->telp != null)
                                         <p style="font-weight: bold">Tel</p>

                                         <p>{{$hQContact->telp}}</p>
                                         @endif
                                         <br>
                                         @if($hQContact->email != null)
                                         <p style="font-weight: bold">Email</p>

                                         <p>{{$hQContact->email}}</p>
                                         @endif
                                         <br>
                                         <a href="{{$hQContact->link}}" class="btn btn-primary"><i class="fa fa-marker"></i> Visit Location</a>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         @endif
                         <div class="row">
                            @foreach ($contacts as $i => $contact)
                             <div class="col-md-6">
                                 <div class="contact-wrap">
                                     <img class="img-responsive"
                                         src="{{ asset('public/' .$contact->getImage->file_name) }}" alt="" />
                                     <div class="list-contact">
                                         <h5 class="title-corporate">{{$contact->name}}</h5>
                                         <br>
                                         <p style="font-weight: bold">Address</p>

                                         <p><a style="color:#999999" href="{{$contact->link}}">
                                            {{$contact->address}}
                                          </a>
                                        </p>
                                         <br>
                                         @if($contact->telp != null)
                                         <p style="font-weight: bold">Tel</p>

                                         <p>{{$contact->telp}}</p>
                                         @endif
                                         <br>
                                         @if($contact->email != null)
                                         <p style="font-weight: bold">Email</p>


                                         <p><a href="mailto:{{$contact->email}}">{{$contact->email}}</a></p>
                                          @endif
                                        <br>
                                         <a href="{{$contact->link}}" class="btn btn-primary"><i class="fa fa-marker"></i> Visit Location</a>
                                     </div>
                                 </div>
                             </div>
                             @endforeach

                         </div>
                     </div>
                 </div>
             </div>
         </section>
     </main>
 @endsection
