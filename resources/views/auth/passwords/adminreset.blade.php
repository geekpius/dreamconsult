<!DOCTYPE HTML>
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

    <div class="card-authentication1 mx-auto my-5 animated bounceInDown">
     <div class="card-group">
         <div class="card mb-0 ">
             <div class="card-body">
                 <div class="card-content p-3">
                     <div class="text-center">
                          <img src="{{ asset('assets/images/logos/main-logo.png') }}" alt="logo icon">
                      </div>
                  <div class="card-title text-uppercase text-center py-3">Reset Password</div>
                    <form id="formSignIn" method="POST" action="{{ url('admin/password/reset') }}">
                        @csrf
                        
                        <input type="hidden" name="token" value="{{ $token }}">
                       <div class="form-group validate">
                        <div class="position-relative has-icon-left">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" value="{{ $email ?? old('email') }}" class="form-control" placeholder="Email">
                              <div class="form-control-position">
                                 <i class="icon-envelope"></i>
                             </div>
                             <span class="text-danger small" role="alert">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                        </div>
                       </div>

                       <div class="form-group validate">
                        <div class="position-relative has-icon-left">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password"  class="form-control" placeholder="Password">
                              <div class="form-control-position">
                                 <i class="icon-lock"></i>
                             </div>
                             <span class="text-danger small" role="alert">{{ $errors->has('password') ? $errors->first('password') : '' }}</span>
                        </div>
                       </div>
                       <div class="form-group validate">
                        <div class="position-relative has-icon-left">
                            <label for="confirm-password" class="sr-only">Confirm Password</label>
                            <input type="password" name="password_confirmation"  class="form-control" placeholder="Confirm Password">
                              <div class="form-control-position">
                                 <i class="icon-lock"></i>
                             </div>
                             <span class="text-danger small" role="alert"></span>
                        </div>
                       </div>
                     <button type="submit" class="btn btn-primary btn-block waves-effect waves-light btn_sign_in"><i class="fa fa-refresh"></i> Reset Password</button>
                      
                 </form>
              </div>
             </div>
         </div>
      </div>
     </div>
 
  <!--Start Back To Top Button-->
 <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
 <!--End Back To Top Button-->
 
 
 
 </div><!--wrapper-->
	
  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
	
  <!-- sidebar-menu js -->
  <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
  
  <!-- Custom scripts -->
  <script src="{{ asset('assets/js/app-script.js') }}"></script>
  
<script>
    $("#formSignIn").on("submit", function(e){
        e.stopPropagation();
        var valid = true;
        $('#formSignIn input').each(function() {
            var $this = $(this);
            
            if(!$this.val()) {
                valid = false;
                $this.parents('.validate').find('span').text('The '+$this.attr('name').replace(/[\_]+/g, ' ')+' field is required');
            }
        });
        if(valid) {
            $('.btn_sign_in').html('<i class="fa fa-spinner fa-spin"></i> Reseting Password...').attr('disabled', true);
            return true;
        }
        return false;
    });

    $("#formSignIn input").on('input', function(){
        if($(this).val()!=''){
            $(this).parents('.validate').find('span').text('');
        }else{ $(this).parents('.validate').find('span').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required'); }
    });
</script>

</body>
</html>