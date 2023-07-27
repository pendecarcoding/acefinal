@extends('acewebfront.layouts2')
@section('content')
    <main>
        <section class="home-section">
            <div class="card card-home">
                <center><img style="height: 130px" src="{{ asset('public/aceweb/assets/img/Go-logo.png') }}">
                </center>

                <center>
                    <h3>Explore our gold trading solutions</h3>
                    <p>Select your ideal option below:</p>
                </center>
                <div class="flex-home">

                    <div class="card-corporate">
                        <a href="{{ url('ourcompany') }}">
                            <center><img class="img-icon-corporate"
                                    src="{{ asset('public/aceweb/assets/img/corporate.png') }}"></center>
                            <!-- <b>CORPORATE</b> -->
                        </a>
                    </div>
                    <div class="card-personal">
                        <a href="{{ url('forcorporate') }}">
                            <center><img class="img-icon-personal"
                                    src="{{ asset('public/aceweb/assets/img/personal.png') }}"></center>
                            <!-- <b>PERSONAL</b> -->
                        </a>
                    </div>

                </div>
                <center>
                    <p>You will be directed to the page based on your selected option.</p>
                </center>

            </div>
        </section>

    </main>
@endsection
