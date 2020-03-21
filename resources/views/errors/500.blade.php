
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content="A travel and tour office management for Dream Consult"/>
  <meta name="author" content="T.K.Pius(Geek) @ VibTech"/>
  <title>Dream Office - Internal Server Error!</title>
  <!--favicon-->
  <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon"/>
  <!-- Bootstrap core CSS-->
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css"/>
  <!-- Custom Style-->
  <link href="{{ asset('assets/css/app-style.css') }}" rel="stylesheet"/>
  <!-- skins CSS-->
  <link href="{{ asset('assets/css/skins.css') }}" rel="stylesheet"/>
</head>
<body>

  <!-- Start wrapper-->
   <div id="wrapper">
  
      <div class="container">
              <div class="row">
                  <div class="col-md-12">
                      <div class="text-center error-pages">
                        <h1 class="error-title text-secondary"> 500</h1>
                        <h2 class="error-sub-title text-dark">Internal server error</h2>

                        <p class="error-message text-dark text-uppercase">Please try after some time</p>
                          
                          <div class="mt-4">
                            <a href="#" class="btn btn-dark btn-round m-1">Go To Home </a>
                            <a href="javascript:history.back();" class="btn btn-warning btn-round m-1">Previous Page </a>
                          </div>
  
                          <div class="mt-4">
                              <p class="">Copyright &copy; <script>document.write(new Date().getFullYear());</script> VibTech Ghana | All rights reserved.</p>
                          </div>
                             <hr class="w-50 border-light">
                          <div class="mt-2">
                              <a href="javascript:void()" class="btn-social btn-facebook btn-social-circle waves-effect waves-light m-1"><i class="fa fa-facebook"></i></a>
                              <a href="javascript:void()" class="btn-social btn-google-plus btn-social-circle waves-effect waves-light m-1"><i class="fa fa-instagram"></i></a>
                              <a href="javascript:void()" class="btn-social btn-behance btn-social-circle waves-effect waves-light m-1"><i class="fa fa-twitter"></i></a>
                              <a href="javascript:void()" class="btn-social btn-dribbble btn-social-circle waves-effect waves-light m-1"><i class="fa fa-github"></i></a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      
   </div><!--wrapper-->
  
  
  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    
  <!-- simplebar js -->
  <script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
  <!-- sidebar-menu js -->
  <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
  <!-- loader scripts -->
  <script src="{{ asset('assets/js/jquery.loading-indicator.js') }}"></script>
  <!-- Custom scripts -->
  <script src="{{ asset('assets/js/app-script.js') }}"></script>
    
  </body>
  </html>
