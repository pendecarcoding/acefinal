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


                         <div style="margin-top: 50px" class="row">
                             <div class="col-md-6">
                                 <div class="contact-wrap">
                                     <img class="img-responsive" src="{{ asset('public/aceweb') }}/assets/img/ACE.jpg"
                                         alt="" />
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="contact-wrap">
                                     <div class="list-contact">
                                         <h5 class="title-corporate">Go Innovate Asia Berhad</h5>
                                         <br>
                                         <p style="font-weight: bold">Address</p>

                                         <p><a style="color:#999999" href="https://waze.com/ul/hw281rehc5">
                                            3A-D, Jalan USJ 10/1a, Taipan Business Centre, 47610 Subang Jaya, Selangor, Malaysia
                                          </a>
                                         <br>
                                         <p style="font-weight: bold">Tel</p>

                                         <p>+603 – 8081 7198</p>
                                         <br>
                                         <p style="font-weight: bold">Email</p>

                                         <p>enquiry@goinno2u.com</p>
                                         <br>
                                         <a href="https://waze.com/ul/hw281rehc5" class="btn btn-primary"><i class="fa fa-marker"></i> Visit Location</a>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="contact-wrap">
                                     <img class="img-responsive"
                                         src="{{ asset('public/aceweb') }}/assets/img/ACECapital.jpg" alt="" />
                                     <div class="list-contact">
                                         <h5 class="title-corporate">Go Capital Growth Sdn. Bhd.</h5>
                                         <br>
                                         <p style="font-weight: bold">Address</p>

                                         <p><a style="color:#999999" href="https://waze.com/ul/hw281rehc5">
                                            3A-D, Jalan USJ 10/1a, Taipan Business Centre, 47610 Subang Jaya, Selangor, Malaysia
                                          </a>
                                        </p>
                                         <br>
                                         <p style="font-weight: bold">Tel</p>

                                         <p>+603 – 8081 7198</p>
                                         <br>
                                         <p style="font-weight: bold">Email</p>

                                         <p>enquiry@goinno2u.com</p>
                                        <br>
                                         <a href="https://waze.com/ul/hw281rehc5" class="btn btn-primary"><i class="fa fa-marker"></i> Visit Location</a>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="contact-wrap">
                                     <img class="img-responsive" src="{{ asset('public/aceweb') }}/assets/img/ACEAssay.jpg"
                                         alt="" />
                                     <div class="list-contact">
                                         <h5 class="title-corporate">Go Assay Sdn. Bhd.</h5>
                                         <br>
                                         <p style="font-weight: bold">Address</p>

                                         <p>
                                             No. 19, Jalan 2/131A, Project Jaya Industrial Estate,
                                             Batu 6, Jalan Klang Lama, 58200 Kuala Lumpur
                                         </p>
                                         <br>
                                         <p style="font-weight: bold">Tel</p>

                                         <p>+603 – 7772 0164</p>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="row">
                             <div class="col-md-6">
                                 <div class="contact-wrap">
                                     <img class="img-responsive"
                                         src="{{ asset('public/aceweb') }}/assets/img/ace-ikhlas.png" alt="" />
                                     <div class="list-contact">
                                         <h5 class="title-corporate">Go Ikhlas Sdn. Bhd.</h5>
                                         <br>
                                         <p style="font-weight: bold">Address</p>

                                         <p>
                                             No. 11A-2, Jalan USJ 10/1D, 47620 Subang Jaya, Selangor
                                             Malaysia
                                         </p>
                                         <br>
                                         <p style="font-weight: bold">Tel</p>

                                         <p>+603 – 8081 7205</p>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="contact-wrap">
                                     <img class="img-responsive"
                                         src="{{ asset('public/aceweb') }}/assets/img/ACE IHSAN (2) 1.png" alt="" />
                                     <div class="list-contact">
                                         <h5 class="title-corporate">Go Ihsan Sdn. Bhd.</h5>
                                         <br>
                                         <p style="font-weight: bold">Address</p>

                                         <p>
                                             No. 11A-2, Jalan USJ 10/1D, 47620 Subang Jaya, Selangor
                                             Malaysia
                                         </p>
                                         <br>
                                         <p style="font-weight: bold">Tel</p>

                                         <p>+603 – 8081 7205</p>
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
