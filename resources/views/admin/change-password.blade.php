@extends('layouts.admin')

@section('content')
<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
  <div class="col-sm-9">
      <h4 class="page-title">Perform change password on account module</h4>
  </div>
</div>
<!-- End Breadcrumb-->


<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
          Change Password   
     </div>
      <div class="card-body">
      <div class="row">
          <div class="col-sm-4"></div>
          <div class="col-sm-4">
              <form id="formChangePassword" method="POST" action="{{ route('admin.changepwd.submit') }}">
                @csrf
                  <div class="form-group validate">
                      <label for="input-1">Current Password</label>
                      <input type="password" name="current_password" class="form-control" id="input-1" placeholder="Enter Current Password">
                      <span class="text-danger small" role="alert">{{ $errors->has('current_password') ? $errors->first('current_password') : '' }}</span>
                  </div> 
                  <div class="form-group validate">
                      <label for="input-1">New Password</label>
                      <input type="password" name="password" class="form-control" id="input-1" placeholder="Enter New Password">
                      <span class="text-danger small" role="alert">{{ $errors->has('password') ? $errors->first('password') : '' }}</span>
                  </div>
                  <div class="form-group validate">
                      <label for="input-1">Confirm New Password</label>
                      <input type="password" name="password_confirmation" class="form-control" id="input-1" placeholder="Confirm New Password">
                      <span class="text-danger small" role="alert">{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '' }}</span>
                  </div> 
                  <div class="form-group">
                      <button type="submit" class="btn btn-block btn-primary px-5 btn_change_password"><i class="fa fa-refresh"></i> Change Password</button>
                  </div>
              </form>
          </div>
      </div>
      </div>
    </div>
  </div>
</div><!-- End Row-->
@endsection
@section('scripts')   
<script>
  $("#formChangePassword").on("submit", function(e){
      e.stopPropagation();
      var valid = true;
      $('#formChangePassword :password').each(function() {
          var $this = $(this);
          
          if(!$this.val()) {
              valid = false;
              $this.parents('.validate').find('span').text('The '+$this.attr('name').replace(/[\_]+/g, ' ')+' field is required');
          }
      });
      if(valid) {
          $('.btn_change_password').html('<i class="fa fa-spinner fa-spin"></i> Changing Password...').attr('disabled', true);
          return true;
      }
      return false;
  });

  $("#formChangePassword input").on('input', function(){
      if($(this).val()!=''){
          $(this).parents('.validate').find('span').text('');
      }else{ $(this).parents('.validate').find('span').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required'); }
  });
</script>

@endsection