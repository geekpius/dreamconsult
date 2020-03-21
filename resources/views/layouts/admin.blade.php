
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content="A travel and tour office management for Dream Consult"/>
  <meta name="author" content="T.K.Pius(Geek) @ VibTech"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dreams Office - {{ $page_title }}</title>
  <!--favicon-->
  <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon"/>
  <!-- Vector CSS -->
  <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
  <!-- simplebar CSS-->
  <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="{{ asset('assets/css/sidebar-menu.css') }}" rel="stylesheet"/>
  <!-- Custom Style-->
  <link href="{{ asset('assets/css/app-style.css') }}" rel="stylesheet"/>
  <!-- skins CSS-->
  <link href="{{ asset('assets/css/skins.css') }}" rel="stylesheet"/>
  <link href="{{ asset('assets/sweetalert/sweetalert.css') }}" rel="stylesheet"/>
  <style>
    .img-upload-photo{
      border-radius: 50% !important;
    }
  
    .text-transform-default{
      text-transform: none !important;
    }
  
  .background-lightskyblue{
    background:lightskyblue !important;
  }

  .background-white{
    background:#ffffff !important;
  }

  .background-black{
    background: #000000 !important;
  }

  .text-white{
    color: #ffffff !important;
  }
  .info-bordered{
    border: solid lightskyblue; 
    border-width: 1px; 
    border-radius: 5px; 
    box-shadow: 5px 5px grey;
  }
  .icon-clickable{
    cursor: pointer;
  }
</style>
  @yield('style')
</head>

<body>

   <!-- start loader -->
   {{-- <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner"><div class="loader"></div></div></div></div> --}}
   <!-- end loader -->

<!-- Start wrapper-->
 <div id="wrapper">
 
  <!--Start sidebar-wrapper-->
  <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
    <div class="brand-logo">
      <a href="{{route('admin.dashboard')}}">
      <img src="{{ asset('assets/images/logos/main-logo.png') }}" class="logo-icon" alt="logo icon">
        <h5 class="logo-text text-transform-default">Dreams Office</h5>
      </a>
    </div>
  <div class="user-details">
   <div class="media align-items-center user-pointer collapsed" data-toggle="collapse" data-target="#user-dropdown">
   <div class="avatar"><img class="mr-3 side-user-img" src="{{asset('assets/images/110x110.png')}}" alt="user avatar"></div>
      <div class="media-body">
      <h6 class="side-user-name">{{ Auth::user()->name }} </h6>
     </div>
      </div>
    <div id="user-dropdown" class="collapse">
     <ul class="user-setting-menu">
           <li><a href="{{ route('admin.changepwd') }}"><i class="icon-lock"></i>  Change Password</a></li>
     <li><a href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="icon-power"></i> Logout</a></li>
     <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
     </ul>
    </div>
     </div>
  <ul class="sidebar-menu">
     <li class="sidebar-header">MAIN NAVIGATION</li>
     <li>
       <a href="{{route('admin.dashboard')}}" class="waves-effect">
         <i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span>
       </a>
     </li>
    @if (Auth::user()->role=='administrator' || Auth::user()->role=='developer')
      <li>
        <a href="{{ route('admin.users') }}" class="waves-effect">
          <i class="fa fa-user-circle"></i> <span>Users</span>
        </a>
      </li>
    @endif

    @if (Auth::user()->role=='administrator' || Auth::user()->role=='developer' || Auth::user()->role=='operations')
      <li>
        <a href="{{ route('admin.branch') }}" class="waves-effect">
          <i class="fa fa-building-o"></i> <span>Branches</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.course') }}" class="waves-effect">
          <i class="fa fa-book"></i> <span>Services</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.price') }}" class="waves-effect">
          <i class="fa fa-money"></i> <span>Prices</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.discount') }}" class="waves-effect">
          <i class="fa fa-percent"></i> <span>Discount Giveout</span>
        </a>
      </li>
    @endif
      
    @if (Auth::user()->role=='administrator' || Auth::user()->role=='developer' || Auth::user()->role=='operations'  || Auth::user()->role=='front desk')
      {{-- <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="fa fa-user"></i> <span>Visitors</span>
          <i class="fa fa-angle-left float-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="{{ route('admin.visitor') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Add New</a></li>
          <li><a href="{{ route('admin.visitor.viewvisitor') }}"><i class="zmdi zmdi-dot-circle-alt"></i> View All</a></li>
        </ul>
      </li> --}}
      <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="fa fa-user-circle-o"></i> <span>Clients</span>
          <i class="fa fa-angle-left float-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="{{ route('admin.student') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Register New</a></li>
          <li><a href="{{ route('admin.viewstudent.incomplete') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Visitors</a></li>
          <li><a href="{{ route('admin.viewstudent') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Registered Clients</a></li>
        </ul>
      </li>
    @endif
    
    @if (Auth::user()->role=='accountant' || Auth::user()->role=='front desk' || Auth::user()->role=='operations' || Auth::user()->role=='administrator' || Auth::user()->role=='developer')
      <li>
        <a href="{{route('admin.makepayment')}}" class="waves-effect">
          <i class="zmdi zmdi-money"></i> <span>Make Payment</span>
        </a>
      </li>    
    @endif

    {{-- @if (Auth::user()->role=='administrator' || Auth::user()->role=='developer') 
      <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="fa fa-users"></i> <span>Employee Module</span>
          <i class="fa fa-angle-left float-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="{{ route('admin.employees') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Employees</a></li>
          <li><a href="{{ route('admin.employees.position') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Job Positions</a></li>
          <li><a href="{{ route('admin.employees.taxes') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Taxes</a></li>
          <li><a href="{{ route('admin.employees.structure') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Salary Structure</a></li>
          <li><a href="{{ route('admin.employees') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Overtime</a></li>
          <li><a href="{{ route('admin.employees.deduction') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Deductions</a></li>
          <li><a href="{{ route('admin.employees') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Generate Payslip</a></li>
          <li><a href="{{ route('admin.employees') }}"><i class="zmdi zmdi-dot-circle-alt"></i> View Payslip</a></li>
        </ul>
      </li>   

    @endif --}}

    @if (Auth::user()->role=='accountant' || Auth::user()->role=='administrator' || Auth::user()->role=='developer' || Auth::user()->role=='operations') 
      <li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="fa fa-bar-chart"></i> <span>Print Reports</span>
          <i class="fa fa-angle-left float-right"></i>
        </a>
        <ul class="sidebar-submenu">
          <li><a href="{{ route('admin.transactions') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Transactions</a></li>
          <li><a href="{{ route('admin.service.transactions') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Service Transactions</a></li>
          <li><a href="{{ route('admin.fullpayers') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Full Payers</a></li>
          <li><a href="{{ route('admin.debtors') }}"><i class="zmdi zmdi-dot-circle-alt"></i> Debtors</a></li>
          <li><a href="{{route('admin.cash.flow')}}"><i class="zmdi zmdi-dot-circle-alt"></i> Cash Flow</a></li>
        </ul>
      </li>   
    @endif
    
    @if (Auth::user()->role=='administrator' || Auth::user()->role=='developer') 
      <li>
        <a href="{{ route('admin.logs') }}" class="waves-effect">
          <i class="fa fa-table"></i> <span>Logs</span>
        </a>
      </li>
    @endif
     <br>
     <li><a href="javaScript:void();" class="waves-effect"><i class="zmdi zmdi-coffee text-danger"></i> <span>Production version 1.1</span></a></li>
    </ul>
  
  </div>

   <!--End sidebar-wrapper-->

<!--Start topbar header-->
<header class="topbar-nav">
    <nav id="header-setting" class="navbar navbar-expand fixed-top">
      <ul class="navbar-nav mr-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link toggle-menu" href="javascript:void();">
          <i class="icon-menu menu-icon"></i>
        </a>
        </li>
        <li class="nav-item">
          <form class="search-bar">
            <input type="text" class="form-control" placeholder="Enter keywords">
            <a href="javascript:void();"><i class="icon-magnifier"></i></a>
          </form>
        </li>
      </ul>
        
      <ul class="navbar-nav align-items-center right-nav-link">

        @if(Auth::user()->role=='developer' || Auth::user()->role=='administrator' || Auth::user()->role=='operations' || Auth::user()->role=='accountant')
        <li class="nav-item dropdown-lg">
          <a class="nav-link dropdown-toggle dropdown-toggle-nocaret waves-effect" data-toggle="dropdown" href="javascript:void();">
            <i class="fa fa-bell-o"></i><span class="badge badge-info badge-up" id="notiTop"></span></a>
            <div class="dropdown-menu dropdown-menu-right">
              <ul class="list-group list-group-flush" id="getNotification">
                
              </ul>
            </div>  
        </li>
        @endif

        <li class="nav-item">
          <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
            <span class="user-profile"><img src="{{ asset('assets/images/110x110.png') }}" class="img-circle" alt="user avatar"></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-right">
          <li class="dropdown-item user-details">
            <a href="javaScript:void();">
              <div class="media">
                <div class="avatar"><img class="align-self-start mr-3" src="{{ asset('assets/images/110x110.png') }}" alt="user avatar"></div>
                <div class="media-body">
                <h6 class="mt-2 user-title">{{ ucwords(Auth::user()->role) }}</h6>
                <p class="user-subtitle">{{ Auth::user()->email }}</p>
                </div>
              </div>
              </a>
            </li>
            <li class="dropdown-divider"></li>
            <li class="dropdown-item"><a href="{{ route('admin.changepwd') }}"><i class="icon-lock mr-2"></i> Change Password</a></li>
            <li class="dropdown-divider"></li>
            <li class="dropdown-item"><a href="{{ route('admin.logout') }}" 
            onclick="event.preventDefault(); document.getElementById('logout-form1').submit();"><i class="icon-power mr-2"></i> Logout</a></li>
            <form id="logout-form1" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </ul>
        </li>
      </ul>
    </nav>
</header>
<!--End topbar header-->

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">

      <!--Start Content-->
      @yield('content')
      <!--End Content-->
<!--start overlay-->
	  <div class="overlay toggle-menu"></div>
	<!--end overlay-->
    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	
	<!--Start footer-->
	<footer class="footer">
      <div class="container">
        <div class="text-center">
          Copyright &copy; <script>document.write(new Date().getFullYear());</script> VibTech Ghana
        </div>
      </div>
    </footer>
	<!--End footer-->
	
	<!--start color switcher-->
   <div class="right-sidebar">
    <div class="switcher-icon">
      <i class="zmdi zmdi-settings zmdi-hc-spin"></i>
    </div>
    <div class="right-sidebar-content">
	
	
	 <p class="mb-0">Header Colors</p>
      <hr>
	  
	  <div class="mb-3">
	    <button type="button" id="default-header" class="btn btn-outline-primary">Default Header</button>
	  </div>
      
      <ul class="switcher">
        <li id="header1"></li>
        <li id="header2"></li>
        <li id="header3"></li>
        <li id="header4"></li>
        <li id="header5"></li>
        <li id="header6"></li>
      </ul>

      <p class="mb-0">Sidebar Colors</p>
      <hr>
	  
      <div class="mb-3">
	    <button type="button" id="default-sidebar" class="btn btn-outline-primary">Default Header</button>
	  </div>
	  
      <ul class="switcher">
        <li id="theme1"></li>
        <li id="theme2"></li>
        <li id="theme3"></li>
        <li id="theme4"></li>
        <li id="theme5"></li>
        <li id="theme6"></li>
      </ul>
      
     </div>
   </div>
  <!--end color switcher-->
  
  </div><!--End wrapper-->

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    
  <!-- simplebar js -->
  <script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
  <!-- sidebar-menu js -->
  <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
  <script src="{{ asset('assets/js/app-script.js') }}"></script>
  <script src="{{ asset('assets/sweetalert/sweetalert.min.js') }}"></script>
  @yield('scripts')
  
<script>
  
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
})

  @if(session()->has('message'))
    swal({
        title: "{!! session()->get('title')  !!}",
        text: "{!! session()->get('message')  !!}",
        type: "{!! session()->get('type')  !!}",
        confirmButtonClass: "btn-primary btn-sm",
        confirmButtonText: "OKAY",
        closeOnConfirm: true
    });
        @php session()->forget('message') @endphp
  @endif
  
  function getNotification(){
    $("#getNotification").load("{{ route('admin.notification') }}");
    setTimeout(getNotification, 1000);
  }
  function getNotiTop(){
    $.ajax({
      url: "{{ route('admin.notitop') }}",
      type: "GET",
      success: function(resp){
        $("#notiTop").text(resp);
      },
      error: function(resp){
        console.log("Something went wrong.");
      }
    });

    setTimeout(getNotiTop, 1000);
  }

  @if(Auth::user()->role=='developer' || Auth::user()->role=='administrator' || Auth::user()->role=='operations' || Auth::user()->role=='accountant')
  getNotiTop();
  getNotification();
  @endif
  </script>
</body>
</html>
