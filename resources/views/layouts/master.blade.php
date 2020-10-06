<!DOCTYPE html>
<html>
  <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css')}}">
    <!-- Custom Font Icons CSS-->
    <link rel="stylesheet" href="{{ asset('assets/css/font.css')}}">
    <!-- Google fonts - Muli-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('assets/css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css')}}">
    @yield('styles')
  </head>
  <body>
    <header class="header">   
      <nav class="navbar navbar-expand-lg">
        <div class="container-fluid d-flex align-items-center justify-content-between">
          <div class="navbar-header">
            <a href="{{ url('/') }}" class="navbar-brand">
              <div class="brand-text brand-big visible text-uppercase"><strong class="text-primary">RANG</strong><strong>REZA</strong></div>
              <div class="brand-text brand-sm"><strong class="text-primary">R</strong><strong>R</strong></div></a>
            <!-- Sidebar Toggle Btn-->
            <button class="sidebar-toggle"><i class="fa fa-long-arrow-left"></i></button>
          </div>
          <div class="right-menu list-inline no-margin-bottom">
            <!-- Log out               -->
            <div class="list-inline-item logout"><a id="logout" href="{{ route('user.logout') }}" class="nav-link">Logout <i class="fa fa-sign-out"></i></a></div>
          </div>
        </div>
      </nav>
    </header>
    <div class="d-flex align-items-stretch">
      <!-- Sidebar Navigation-->
      <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
          <div class="avatar"><img src="{{ asset('assets/img/avatar-6.jpg')}}" class="img-fluid rounded-circle"></div>
          <div class="title">
            <h1 class="h5">{{ Auth::user()->name }}</h1>
            <p>{{ Auth::user()->getRoleNames()[0] }}</p>
          </div>
        </div>
        {{-- <span class="heading">Main</span> --}}
        <ul class="list-unstyled">
            <li class="{{ (Request::is('home')?'active':'') }}"><a href="{{ route('home') }}"> <i class="icon-home"></i>Dashboard </a></li>
            <li class="{{ (Request::is('products')?'active':'') }}"><a href="{{ route('product.index') }}"><i class="fa fa-product-hunt"></i> Products</a></li>
            <li class="{{ (Request::is('admin/resellers')?'active':'') }}
            {{ (Request::is('admin/reseller/create')?'active':'') }}"><a href="{{ route('admin.reseller.index') }}"><i class="fa fa-users"></i> Resellers</a></li>
            <li class="{{ (Request::is('admin/discounts')?'active':'') }}
            {{ (Request::is('admin/discount/create')?'active':'') }}"><a href="{{ route('admin.discount.index') }}"><i class="fa fa-percent"></i> Discounts</a></li>
        </ul>
      </nav>
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
              <h2 class="h5 no-margin-bottom">@yield('page-title')</h2>
            </div>
          </div>
        @yield('content')
        <footer class="footer">
          <div class="footer__block block no-margin-bottom">
            <div class="container-fluid text-center">
              <!-- Please do not remove the backlink to us unless you support us at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
               <p class="no-margin-bottom">2020 &copy; Rang Reza. All Rights Reserved.</p>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/popper.js/umd/popper.min.js') }}"> </script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
    {{-- <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/charts-home.js')}}"></script> --}}
    <script src="{{ asset('assets/js/front.js')}}"></script>
    @yield('scripts')
  </body>
</html>