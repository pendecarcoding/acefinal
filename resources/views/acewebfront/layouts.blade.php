<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="
    https://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="description" content="" />
    <meta name="theme-color" content="#264e77" />

    <meta name="generator" content="Hugo 0.104.2" />
    <link rel="icon"
        href="https://aceweb.kanalapps.web.id/public/uploads/all/sfGZMHPHsxYDerGPCBKsZYgTze8TMq55iPlnP01y.png">
    <title>@if (!empty($page))
        ACE INOVATE ASIA BERHARD |{{ strtoupper($page) }}

    @else
        @yield('title')
        @endif
    </title>

    <meta property="og:image" content="{{ uploaded_asset(get_setting('meta_image')) }}" />

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/carousel/" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="{{ static_asset('aceweb') }}/assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="{{ static_asset('aceweb') }}/assets/ace/mansoryscroll.css" rel="stylesheet" />
    <link href="{{ static_asset('aceweb') }}/assets/ace/company.css" rel="stylesheet" />
    <script src="{{ static_asset('aceweb') }}/assets/mansory/mansory.js"></script>



    <link href="{{ static_asset('aceweb') }}/assets/dist/css/bootstrap.min.css" rel="stylesheet" />


    <!-- Custom styles for this template -->
    <link href="{{ static_asset('aceweb') }}/assets/carousel/carousel.css" rel="stylesheet" />

    <link href="{{ static_asset('aceweb') }}/assets/ace/acev1.css" rel="stylesheet" />
    <link href="{{ static_asset('aceweb') }}/assets/ace/acev2.css" rel="stylesheet" />
    <!--<link href="assets/ace/scroll.css" rel="stylesheet" />-->
    <link href="{{ static_asset('aceweb') }}/assets/slick/slick.css" rel="stylesheet" />
    <link href="{{ static_asset('aceweb') }}/assets/slick/slick-theme.css" rel="stylesheet" />
    <!--<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />-->
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>


    <!--TEST-->

    <!--TEST-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/Flip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="{{ static_asset('aceweb') }}/assets/ace/ipadace1.css" rel="stylesheet" />




    <style>
        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: #1d5189;
            color: white;
            cursor: pointer;
            /* padding: 15px; */
            border-radius: 50%;
        }

        #myBtn:hover {
            background-color: #555;
        }

    </style>


</head>

<body>
    <!--<div class="centerloader">
    <div id="loader" class="loader"></div>
</div>-->
    <!--div id="divbody" data-aos="fade-up" class="divbody">-->
    <a href="{{ route('home') }}"><img id="acetopbar" class="acetopbar"
            src="{{ uploaded_asset(get_setting('site_icon')) }}" /></a>

    @include('acewebfront.header')


    @yield('content')

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">


                <div class="card text-left">
                    <div class="card-body" style="
                    padding: 50px;
                ">
                        <div class="mb-5 text-center">
                            <img src="{{ uploaded_asset(get_setting('site_icon')) }}"
                                class="mw-100 mb-4" height="100">
                            <h1 style="color: #6d6d6d;font-size: 20px;" class="h3  mb-0">Staff Login</h1>

                        </div>
                        <form class="pad-hor" method="POST" role="form" action="{{route('staff.login')}}">
                            {{csrf_field()}}
                            <div style="margin-left: 20px;margin-right: 20px;">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span style="height: 40px;
                                      border-radius: 0px;" class="input-group-text" id="basic-addon1"><i
                                                class="fa fa-user"></i></span>
                                    </div>
                                    <input required name="username" type="text" class="form-control" placeholder="Username" aria-label="Username"
                                        aria-describedby="basic-addon1">
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span style="height: 40px;
                                      border-radius: 0px;" class="input-group-text" id="basic-addon1"><i
                                                class="fa fa-lock"></i></span>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" required=""
                                        placeholder="Password">
                                </div>
                            </div>

                            <div class="row mb-2">

                            </div>
                            <div class="form-group">
                                <button style="width:100%;background-color: #264e77;border: #264e77;" type="submit"
                                    class="btn btn-primary btn-lg btn-block">
                                    LOGIN
                                </button>
                                <br>
                                <center>
                                    <p style="margin-top: 5px;color:#959595">Don't have an account? <span><a style="color:#959595;text-decoration: none;"
                                                href="{{ url('registerstaff') }}">Create
                                                account</a></span></p>

                                    <p><span><a style="color:#959595;text-decoration: none;"
                                        href="{{ url('forgotpass') }}">Forgot Password</a></span></p>
                                </center>

                            </div>
                        </form>

                    </div>
                </div>


            </div>
        </div>
    </div>


    @include('acewebfront.fotter')
    <!--</div>-->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const canvas = document.getElementById("hero-lightpass");





        $('#requestpatnerform').submit(function (event) {
            event.preventDefault();
            $("#loading").show();
            $.ajax({
                url: '{{ route('forcorporate.addrequest') }}',
                type: 'POST',
                data: $('#requestpatnerform').serialize(),
                success: function (response) {
                    if (response == "success") {

                        $("#alertpatner").show();
                        $("#requestpatnerform")[0].reset();
                    }
                },
                complete: function () {
                    $("#loading").hide();
                }
            });
        });

    </script>
    <script>
        var myVar;

        function LoadFunction() {
            myVar = setTimeout(showPage, 1500);
        }

        function showPage() {

            document.getElementById("loader").style.display = "none";
            document.getElementById("divbody").style.display = "block";
        }

    </script>

    <script type="text/javascript">
        var scrollnum = 300;

        // Get the button
        let mybutton = document.getElementById("myBtn");

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        function progressBarScroll() {

            let winScroll = document.body.scrollTop || document.documentElement.scrollTop,
                height = document.documentElement.scrollHeight - document.documentElement.clientHeight,
                scrolled = (winScroll / height) * 190;
            console.log("Hasil " + scrolled);
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
            if (scrolled >= 30 && scrolled <= 100) {
                scrollnum = 250;
                document.getElementById("progressBar").style.height = scrolled + "%";
            }
            // if(scrolled >= 90 && scrolled <= 100){
            //     scrollnum = 200;
            //     document.getElementById("progressBar").style.height = "30%";
            // }
            if (scrolled <= 100 && scrolled >= 56) {
                document.getElementById("progressBar").style.height = scrolled + "%";
            }
            // if (scrolled == 90){
            //     alert("dah 90 dah");
            // }

        }

        window.onscroll = function () {

            progressBarScroll();


        };

    </script>
    <script type="text/javascript">
        function fadeingtp(section, classname) {
            var element = document.getElementById("myDIV");
            var classfromdiv = document.getElementById("myDIV").className;
            //console.log(classfromdiv);



        }

        $(window).on("scroll", function () {

            //document.getElementById("progressBar").style.height =  window.innerHeight;




            if (
                $(window).scrollTop() >=
                $(".number").offset().top +
                $(".number").outerHeight() -
                window.innerHeight
            ) {
                if (!localStorage.getItem("visited")) {
                    $(".number").each(function () {
                        $(this)
                            .prop("Counter", 0)
                            .animate({
                                Counter: $(this).text(),
                            }, {
                                duration: 2000,
                                easing: "swing",
                                step: function (now) {
                                    $(this).text(Math.ceil(now));
                                },
                            });
                    });
                    $(".decimal").each(function () {
                        $(this)
                            .prop("Counter", 0)
                            .animate({
                                Counter: $(this).text(),
                            }, {
                                duration: 2000,
                                easing: "swing",
                                step: function (now) {
                                    $(this).text(parseFloat(now).toFixed(1));
                                },
                            });
                    });
                    localStorage.setItem("visited", true);
                }
            } else {
                localStorage.removeItem("visited");
            }
        });


        $(document).ready(function () {

            $(window).on("scroll", function () {

                if (
                    $(window).scrollTop() >=
                    $(".company-ace").offset().top +
                    $(".company-ace").outerHeight() -
                    window.innerHeight
                ) {
                    document.getElementById("gtp").style.display = "block";
                    document.getElementById("gpt1").style.height = "600px";
                    document.getElementById("gpt2").style.height = "600px";
                    document.getElementById("gpt3").style.height = "600px";
                    document.getElementById("gpt4").style.height = "600px";
                    document.getElementById("gpt5").style.height = "600px";


                }





                if (
                    $(window).scrollTop() >=
                    $("#mansory").offset().top +
                    $("#mansory").outerHeight() -
                    window.innerHeight
                ) {

                    $(".grid-item").each(function (i) {
                        setTimeout(function () {
                            $(".grid-item").eq(i).addClass("is-visible");
                        }, 200 * i);
                    });


                }

                if (
                    $(window).scrollTop() >=
                    $("#nonmansory").offset().top +
                    $("#nonmansory").outerHeight() -
                    window.innerHeight
                ) {

                    $(".grid-item").each(function (i) {
                        setTimeout(function () {
                            $(".grid-item").eq(i).removeClass("is-visible");
                        }, 200 * i);
                    });


                }
                if (
                    $(window).scrollTop() >=
                    $("#gpt0").offset().top +
                    $("#gpt0").outerHeight() -
                    window.innerHeight
                ) {
                    var to = document.getElementById("to-progress");
                    var img = document.getElementById("imggpt1");
                    var titleprogress = document.getElementById("title-progress");
                    var contentprogress = document.getElementById("content-progress");
                    //$("#imggpt1").fadeIn(30);
                    //changeimage("{{ static_asset('aceweb') }}/assets/img/gtp1.png");




                    to.innerHTML = "1/5";
                    titleprogress.innerHTML = "Supports both B2B & B2C integration";
                    contentprogress.innerHTML =
                        "Our potential partners can create their own product branding and launch their own digital gold program with the help of our ready-made templates and API.";

                    $(".gptimg-responsive").addClass("is-visible");

                }
                if (
                    $(window).scrollTop() >=
                    $("#gpt1").offset().top +
                    $("#gpt1").outerHeight() -
                    window.innerHeight
                ) {
                    var to = document.getElementById("to-progress");
                    var titleprogress = document.getElementById("title-progress");
                    var contentprogress = document.getElementById("content-progress");
                    //changeimage("{{ static_asset('aceweb') }}/assets/img/gtp2.png");
                    //$("#imggpt1").fadeIn(3000);
                    //document.getElementById("imggpt1").src="{{ static_asset('aceweb') }}/assets/img/gtp2.png";
                    $(".gptimg-responsive").addClass("is-visible");
                    to.innerHTML = "2/5";
                    titleprogress.innerHTML = "Streamlined customer onboarding process";
                    contentprogress.innerHTML =
                        "Existing or new customers will go through an onboarding process for every partner is platform while meeting the regulatory requirements such as e-KYC, AML & Pep checking.";


                }
                if (
                    $(window).scrollTop() >=
                    $("#gpt2").offset().top +
                    $("#gpt2").outerHeight() -
                    window.innerHeight
                ) {
                    var to = document.getElementById("to-progress");
                    var titleprogress = document.getElementById("title-progress");
                    var contentprogress = document.getElementById("content-progress");
                    //$("#imggpt1").fadeIn(3000);
                    //document.getElementById("imggpt1").src="{{ static_asset('aceweb') }}/assets/img/gtp3.png";
                    //changeimage("{{ static_asset('aceweb') }}/assets/img/gtp3.png");
                    $(".gptimg-responsive").addClass("is-visible");
                    to.innerHTML = "3/5";
                    titleprogress.innerHTML =
                        "Buy & sell transactions including future orders";
                    contentprogress.innerHTML =
                        "Customers have the ability to buy, sell, convert, transfer, and perform future orders at their own convenience on the gold trading platform.";

                }
                if (
                    $(window).scrollTop() >=
                    $("#gpt3").offset().top +
                    $("#gpt3").outerHeight() -
                    window.innerHeight
                ) {

                    var to = document.getElementById("to-progress");
                    var titleprogress = document.getElementById("title-progress");
                    var contentprogress = document.getElementById("content-progress");
                    //changeimage("{{ static_asset('aceweb') }}/assets/img/gtp4.png");
                    //$("#imggpt1").fadeIn(3000);
                    // document.getElementById("imggpt1").src="{{ static_asset('aceweb') }}/assets/img/gtp4.png";
                    $(".gptimg-responsive").addClass("is-visible");
                    to.innerHTML = "4/5";
                    titleprogress.innerHTML =
                        "Seamless integration with payment gateways & e-wallets";
                    contentprogress.innerHTML =
                        "Partners are able to enjoy smooth payment transactions with the ability of connecting to the preferred payment gateways and e-wallets.";

                }
                if (
                    $(window).scrollTop() >=
                    $("#gpt4").offset().top +
                    $("#gpt4").outerHeight() -
                    window.innerHeight
                ) {

                    var to = document.getElementById("to-progress");
                    var titleprogress = document.getElementById("title-progress");
                    var contentprogress = document.getElementById("content-progress");
                    //$("#imggpt1").fadeIn(3000);
                    //document.getElementById("imggpt1").src =
                    //   "{{ static_asset('aceweb') }}/assets/img/gtp4.png";
                    //changeimage("{{ static_asset('aceweb') }}/assets/img/gtp4.png");
                    var height = $("#gpt4").outerHeight() - window.innerHeight + "vh";
                    to.innerHTML = "5/5";
                    titleprogress.innerHTML =
                        "Fulfill conversion requests anytime, anywhere";
                    contentprogress.innerHTML =
                        "Account holders are able to make conversion requests anytime of the day while we provide the necessary delivery and insurance coverage.";

                }
                if ($(window).scrollTop() >=
                    $("#gpt5").offset().top +
                    $("#gpt5").outerHeight() -
                    window.innerHeight) {

                    const myDiv = document.getElementById("gtp-patner-focused");
                    // myDiv.scrollIntoView();

                }
                if ($(window).scrollTop() >=
                    $("#gpt6").offset().top +
                    $("#gpt6").outerHeight() -
                    window.innerHeight) {
                    // document.getElementById("gtp").style.display = "none";

                }

            });
        });

    </script>

    <script>
        function myFunction() {
            var y = document.getElementById("acetopbar");
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.style.left = "0%";
                x.className += " responsive";
                y.style.display = "none";
            } else {
                x.className = "topnav";
                y.style.display = "block";
            }
        }

    </script>

    <script src="{{ static_asset('aceweb') }}/assets/vendor/aos/aos.js"></script>
    <!-- <script src="{{ static_asset('aceweb') }}/assets/js/mansoryscroll.js"></script> -->

    <!--Mansory Scroll-->
    @php
    $datapatner = getPatner();
    @endphp
    <script>
        var images = [
            @foreach($datapatner as $i => $p)
           "{{getimage($p->image)}}",
            @endforeach
    ];

  console.log(images);

  var lists = document.getElementsByClassName("selfie-img");
  var list = lists;
  console.log(lists);
  console.log(list);
  // Var or Let works in the for loop
  let counter = 0;
  let counter2 = 0;
  for (let i = 0; i < lists.length; i++) {
    // console.log(list[i]);
    if (i < images.length) {
      list[i].style.backgroundImage = "url(" + images[i] + ")";
    } else if (i < 2 * images.length) {
      list[i].style.backgroundImage = "url(" + images[counter] + ")";
      counter = counter + 1;
    } else {
      list[i].style.backgroundImage = "url(" + images[counter2] + ")";
      counter2 = counter2 + 1;
    }
  }

  var clone1 = $(".col1 ul li").clone();
  clone1.appendTo(".col1 ul");
  var clone2 = $(".col2 ul li").clone();
  clone2.appendTo(".col2 ul");
  var clone3 = $(".col3 ul li").clone();
  clone3.appendTo(".col3 ul");

    </script>
    <!--END MAnsory-->
    <script src="{{ static_asset('aceweb') }}/assets/ace/gtpscroll.js" type="text/javascript">
    </script>
    <script src="{{ static_asset('aceweb') }}/assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script>
        if (!window.Cypress) AOS.init();

    </script>
    <script type="text/javascript">
        $(".slider-service").slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
        });

    </script>
    <script>
        let magicGrid = new MagicGrid({
            container: ".mansory",
            animate: true,
            gutter: 30,
            static: true,
            useMin: true,
        });

        magicGrid.listen();

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script type="text/javascript">
        $(function () {
            // Masonry Grid
            $(".grid").masonry({
                itemSelector: ".grid-item",
                columnWidth: 180,
                fitWidth: true, // When enabled, you can center the container with CSS.
                gutter: 10
            });

            // Loading Animation
            /*$(".grid-item").each(function (i) {
              setTimeout(function () {
                $(".grid-item").eq(i).addClass("is-visible");
              }, 200 * i);
            });*/

            // Fancybox
            $(".fancybox").fancybox({
                helpers: {
                    overlay: {
                        locked: false
                    }
                }
            });
        });

    </script>



    <script>
        window.addEventListener("online",
            () => livestatus("online")
        );
        window.addEventListener("offline",
            () => livestatus("offline")

        );

        function livestatus(status) {
            if (status == "online") {
                document.getElementById("statuslive").innerHTML = 'LIVE';
                document.getElementById("statuslive").style.color = "#1ac69c";
                document.getElementById("tradeopen-mobile").style.color = "#1ac69c";
                connect();
            } else {

                document.getElementById("statuslive").innerHTML = 'NO INTERNET';
                document.getElementById("statuslive").style.color = "red";

                document.getElementById("tradeopen-mobile").innerHTML = 'NO INTERNET';
                document.getElementById("tradeopen-mobile").style.color = "red";

            }
        }

    </script>


    <script>

    </script>

<script>
    window.addEventListener('wheel', function(event) {
      if (event.ctrlKey == true) {
        event.preventDefault();
      }
    });
  </script>







</body>

</html>
