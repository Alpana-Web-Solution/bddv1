<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('pages.parts.seo')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AlpanA') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@coreui/coreui/dist/css/coreui.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style type="text/css">
        body {
              padding-top: 56px;
            }

            .carousel-item {
              height: 50vh;
              min-height: 240px;
              background: no-repeat center center scroll;
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
            }

            .portfolio-item {
              margin-bottom: 30px;
            }
    </style>
</head>
<body>

    <!-- Navigation -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
      <a class="navbar-brand" href="{{route('home')}}">
                    <img style="margin-top: -10px;" class="navbar-brand-full" src="{{env('APP_LOGO')??'https://res.cloudinary.com/debjit/image/upload/v1598972041/149_50_logo_uas3uf.png'}}" width="118" height="46" alt="{{ config('app.name', 'ALpanA') }}">
                </a>
      {{-- <a class="navbar-brand" href="{{env('APP_URL')}}">{{ config('app.name', 'ALpanA') }}</a> --}}
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <a class="nav-link" href="{{route('home')}}">{{__("Home")}}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('about')}}">{{__("About")}}</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('contact')}}">{{__("Contact")}}</a>
          </li>
          <li class="nav-item">
                    <a class="nav-link" href="{{ route('requisition.create') }}">{{ __('Request Blood') }}</a>
          </li>
          @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->is_admin ==1 )
                                    <a class="dropdown-item" href="{{route('user.profile')}}">{{__("Profile")}}</a>
                                    <a class="dropdown-item" href="{{route('admin.dashboard')}}">{{__("Dashboard")}}</a>
                                    @else
                                    <a class="dropdown-item" href="{{route('donation.index')}}">{{__("Donation")}}</a>
                                    <a class="dropdown-item" href="{{route('user.profile')}}">{{__('Profile')}}</a>
                                    <a class="dropdown-item" href="{{route('user.dashboard')}}">{{__("Dashboard")}}</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        <li class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ strtoupper(app()->getLocale()) }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                @foreach(['en'=>'English','bn'=>'বাংলা'] as $langLocale => $langName)
                                    <a class="dropdown-item" href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }} ({{ $langName }})</a>
                                @endforeach
                            </div>
                        </li>
        </ul>
      </div>
    </div>
  </nav>

  <header>
    @include('pages.parts.carousel')
  </header>

  <!-- Page Content -->
  <div class="container">

    <h1 class="my-4">{{trans('Welcome to')}} {{ config('app.name', 'ALpanA') }}</h1>
    <p>{{(!empty($data->parts) AND !empty($data->parts['details'])) ? $data->parts['details']:trans('Welcome to our site.')}}</p>

    <!-- Marketing Icons Section -->
    <div class="row">
      <div class="col-lg-4 mb-4">
        <div class="card h-100 shadow">
          <h4 class="card-header">{{__("Donate Blood")}}</h4>
          <div class="card-body">
            <p class="card-text">{{__('We need more donor as one can donate once every 60 days. Join our volunteer base by signing up.')}}</p>
          </div>
          <div class="card-footer">
            <a href="{{ route('register') }}" class="btn btn-primary">{{__('Register As Donor')}}</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="card h-100 shadow">
          <h4 class="card-header">{{__("Request Blood Donation")}}</h4>
          <div class="card-body">
            <p class="card-text">{{__("Are you in need of a blood donor? Please request using this form. We will contact ASAP.")}}</p>
          </div>
          <div class="card-footer">
            <a href="{{route('requisition.create')}}" class="btn btn-primary">{{__("Ask For Blood Donation")}}</a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <div class="card h-100 shadow">
          <h4 class="card-header">{{__("Share")}}</h4>
          <div class="card-body">
            <p class="card-text">{{__("Sharing is Caring. Spread the word and share with your friend and family so they can easily find us when needed.")}}</p>
          </div>
          <div class="card-footer">
            <a href="#" class="btn btn-primary">{{__('Share')}}</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->

    <!-- Features Section -->
    <div class="row">
      <div class="col-lg-6">
        <h2>{{__("Who are we ?")}}</h2>
        @if(!empty($data->parts) AND !empty($data->parts['who_are_we']))
        {!! $data->parts['who_are_we'] !!}
        @else
        <p>{{__("We are a group of volunteers helping people with blood donations. Plese keep in mind :")}}</p>
        <ul>
          <li>
            <strong>{{__("Request with a clean picture of the requisition.")}}</strong>
          </li>
          <li>
          <strong>{{__("Do Not Offer Money! Please buy food instead.")}}</strong>
            </li>
          <li><strong>{{__("We can ask you / your contact to donate for other requests.")}}</strong></li>
          <li><strong>{{__("We may ask you to arrange transport for the volunteer's round trip.")}}</strong></li>
          <li><strong>{{__("Please responds to our call, otherwise, we may blacklist you.")}}</strong></li>
        </ul>
        <p>{{__("We donate blood and engage with social work voluntarily. Please consider paying parking, transport and food fees if the hospital is far.")}}</p>
        @endif
      </div>
      <div class="col-lg-6">
        <img class="img-fluid rounded" src="{{(!empty($data->parts) AND !empty($data->parts['who_are_we_img'])) ? $data->parts['who_are_we_img'] : 'https://res.cloudinary.com/debjit/image/upload/v1616315953/abdd/carosoul/tim-marshall-cAtzHUz7Z8g-unsplash.jpg'}}" >
      </div>
    </div>
    <!-- /.row -->
{{--
    <hr>

    <!-- Call to Action Section -->
    <div class="row mb-4">
      <div class="col-md-8">
        <p>{{__("Join our email newsletter, which we send every month. Please Help us by spreading the links and register as a donor.")}}</p>
      </div>
      <div class="col-md-4">
        <a class="btn btn-lg btn-secondary btn-block" href="#">{{__("Join Our News Letter")}}</a>
      </div>
    </div>
--}}
  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-light">
    <div class="container">
        <hr>
      <p class="m-0 text-center text-black">Copyright &copy; {{ config('app.name', 'ALpanA') }} 2021 </p><span style="float: right">Made with <i style="color: red;" class="fa fa-heart" aria-hidden="true"></i> and Donated by&nbsp;<a href="https://alpana.org/">Alpana Web Solutions</a></span>
    </div>
    <!-- /.container -->
  </footer>
</body>

</html>