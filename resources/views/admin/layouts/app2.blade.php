<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
      <title>BinAbba Logistics</title>
    <!-- Fontfaces CSS-->
    <link href="{{asset('css/font-face.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/font-awesome-4.7/cssx/font-awesome.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{asset('vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{asset('vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/wow/animate.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/slick/slick.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
    <link href="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{asset('css/theme.css')}}" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.html">
                            <img src="{{asset('images/binabbalogomin.png')}}" alt="BinAbba" />
                        </a>Bin-Abba
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="">
                            <a class="js-arrow" href="/home">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                         <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-fw fa-users"></i>Clients</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                               <li>
                                    <a href="/clients/create">Add New Client</a>
                                </li> 
                                <li>
                                    <a href="/clients">View Clients List</a>
                                </li>
                                <li>
                                    <a href="/clients/pdf">Download Clients List</a>
                                </li>
                               
                            </ul>
                        </li>

                         <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-fw fa-truck"></i>Trucks</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                               <li>
                                    <a href="/trucks/create">Add New Truck</a>
                                </li>
                                <li>
                                    <a href="/trucks">View Trucks List</a>
                                </li>
                                <li>
                                    <a href="/trucks/pdf">Download Trucks List</a>
                                </li>
                               
                            </ul>
                        </li>

                         <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-fw fa-users"></i>Drivers</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                               <li>
                                    <a href="/drivers/create">Add New Driver</a>
                                </li>
                                <li>
                                    <a href="/drivers">View Drivers List</a>
                                </li>
                                <li>
                                    <a href="#">Download Drivers List</a>
                                </li>
                               
                            </ul>
                        </li>

                         <li class="has-sub">
                            <a class="js-arrow" href="">
                                <i class="fa fa-fw fa-boxes"></i>Goods</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                               <li>
                                    <a href="/goods/create">Add New Goods</a>
                                </li>
                                
                                <li>
                                    <a href="/goods">View Goods List</a>
                                </li>
                                <li>
                                    <a href="/goods/dpdf">Download Delivered Goods List</a>
                                </li>
                                   <li>
                                    <a href="/goods/pdf">Download Undelivered Goods List</a>
                                </li>
                               
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Payment</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                               <li>
                                    <a href="/payments/create">Add New Payment</a>
                                </li>
                                 <li>
                                    <a href="/payments">View Payment List</a>
                                </li>
                                <li>
                                    <a href="/payments/cpdf">Download Completed Payment List</a>
                                </li>
                                <li>
                                    <a href="/payments/pdf">Download Uncompleted Payment List</a>
                                </li>
                               
                            </ul>
                        </li>
                          <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Expenses</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                               <li>
                                    <a href="/expenses/create">Add New Expenses</a>
                                </li>
                                 <li>
                                    <a href="/expenses">View Expenses List</a>
                                </li>
                                <li>
                                    <a href="/expenses/pdf">Download Expenses List</a>
                                </li>
                               
                            </ul>
                        </li>

                          <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Fuel Debts</a>
                            <ul class="navbar-mobile-sub__list list-unstyled js-sub-list">
                               <li>
                                    <a href="/fuelDebt/create">Add New Fuel Debt</a>
                                </li>
                                 <li>
                                    <a href="/fuelDebt">View Fuel Debt List</a>
                                </li>
                                <li>
                                    <a href="/fuelDebt/pdf">Download Fuel Debt List</a>
                                </li>
                               
                            </ul>
                        </li>
                       

                       
                       
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="{{asset('imgs/binabbalogomin.png')}}" alt="BinAbba" /><h2> Bin-Abba</h2>
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="active ">
                            <a class="js-arrow" href="/home">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                         <li class="active has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-fw fa-users"></i>Clients</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/clients/create">Add New Client</a>
                                </li> 
                                <li>
                                    <a href="/clients">View Clients List</a>
                                </li>
                                <li>
                                    <a href="/clients/pdf">Download Clients List</a>
                                </li>
                               
                            </ul>
                        </li>
                        <li class="active has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-fw fa-truck"></i>Trucks</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/trucks/create">Add New Truck</a>
                                </li>
                                <li>
                                    <a href="/trucks">View Trucks List</a>
                                </li>
                                <li>
                                    <a href="/trucks/pdf">Download Trucks List</a>
                                </li>
                            </ul>
                        </li>

                        <li class="active has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-fw fa-users"></i>Drivers</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                 <li>
                                    <a href="/drivers/create">Add New Driver</a>
                                </li>
                                <li>
                                    <a href="/drivers">View Drivers List</a>
                                </li>
                                <li>
                                    <a href="#">Download Drivers List</a>
                                </li>
                               
                            </ul>
                        </li>

                        
                        <li class="active has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-fw fa-boxes"></i>Goods</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/goods/create">Add New Goods</a>
                                </li>
                                
                                <li>
                                    <a href="/goods">View Goods List</a>
                                </li>
                                <li>
                                    <a href="/goods/dpdf">Download Delivered Goods List</a>
                                </li>
                                   <li>
                                    <a href="/goods/pdf">Download Undelivered Goods List</a>
                                </li>
                               
                            </ul>
                        </li>

                          <li class="active has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-fw fa-money-bill"></i>Payment</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/payments/create">Add New Payment</a>
                                </li>
                                 <li>
                                    <a href="/payments">View Payment List</a>
                                </li>
                                <li>
                                    <a href="/payments/cpdf">Download Completed Payment List</a>
                                </li>
                                <li>
                                    <a href="/payments/pdf">Download Uncompleted Payment List</a>
                                </li>
                               
                            </ul>
                        </li>
                          <li class="active has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-money-bill"></i>Expenses</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                               <li>
                                    <a href="/expenses/create">Add New Expenses</a>
                                </li>
                                 <li>
                                    <a href="/expenses">View Expenses List</a>
                                </li>
                                <li>
                                    <a href="/expenses/pdf">Download Expenses List</a>
                                </li>
                               
                            </ul>
                        </li>

                        <li class="active has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fa fa-money-bill"></i>Fuel Debts</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                               <li>
                                    <a href="/fuelDebt/create">Add New Fuel Debt</a>
                                </li>
                                 <li>
                                    <a href="/fuelDebt">View Fuel Debt List</a>
                                </li>
                                <li>
                                    <a href="/fuelDebt/pdf">Download Fuel Debt List</a>
                                </li>
                               
                            </ul>
                        </li>




                       
                       
                       
                       
                       
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="POST">
                               
                                    
                                </button>
                            </form>
                            <div class="header-button">
                                <div class="noti-wrap">
                                        @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                <li class="nav-item">
                                    @if (Route::has('register'))
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    @endif
                                </li>
                            @else
                                    
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                       
                                        <div class="content">
                                            <a class="js-acc-btn" href="#">  {{ Auth::user()->fullName }}</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#">  {{ Auth::user()->fullName }}</a>
                                                    </h5>
                                                    <span class="email">  {{ Auth::user()->email }}</span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                               
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             @endguest
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">


             @include('inc.messages')
             @yield('content')



                </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="{{asset('vendor/jquery-3.2.1.min.js')}}"></script>
    <!-- Bootstrap JS-->
    <script src="{{asset('vendor/bootstrap-4.1/popper.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
    <!-- Vendor JS       -->
    <script src="{{asset('vendor/slick/slick.min.js')}}"> </script>
    <script src="{{asset('vendor/wow/wow.min.js')}}"></script>
    <script src="{{asset('vendor/animsition/animsition.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}">  </script>
    <script src="{{asset('vendor/counter-up/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('vendor/counter-up/jquery.counterup.min.js')}}">
    </script>
    <script src="{{asset('vendor/circle-progress/circle-progress.min.js')}}"></script>
    <script src="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('vendor/chartjs/Chart.bundle.min.js')}}"></script>
    <script src="{{asset('vendor/select2/select2.min.js')}}">
    </script>

    <!-- Main JS-->
    <script src="{{asset('js/main.js')}}"></script>

</body>

</html>
<!-- end document-->
