@extends('layouts.admin')
@section('style')  
@endsection
@section('content')
<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Perform this activities on client module</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Edit</a></li>
        </ol>
    </div>
</div>
<!-- End Breadcrumb-->
 

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
           Edit Client &nbsp;&nbsp;||&nbsp;&nbsp;
           <a href="{{ route('admin.viewstudent') }}">Go Back</a> 
       </div>
        <div class="card-body row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <form id="formAddNew" method="POST" action="{{ route('admin.student.update') }}">
                    @csrf
                    <input type="hidden" value="{{ $user->id }}" name="user_id" readonly>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group validate">
                                <label>First Name<i class="text-danger">*</i></label>
                                <input type="text" name="first_name" value="{{ $user->first_name }}" class="form-control" placeholder="Enter First Name">
                                <span class="text-danger small" role="alert">{{ $errors->has('first_name') ? $errors->first('first_name') : '' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group validate">
                                <label>Last Name<i class="text-danger">*</i></label>
                                <input type="text" name="last_name" value="{{ $user->last_name }}" class="form-control" placeholder="Enter Last Name">
                                <span class="text-danger small" role="alert">{{ $errors->has('last_name') ? $errors->first('last_name') : '' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Enter Email Address">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group validate">
                                <label>Phone Number<i class="text-danger">*</i></label>
                                <input type="text" name="phone_number" value="{{ $user->phone }}" maxlength="10" class="form-control" placeholder="Enter Phone Numbers">
                                <span class="text-danger small" role="alert">{{ $errors->has('phone_number') ? $errors->first('phone_number') : '' }}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-danger">PROFILE INFO</div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" value="{{ $user->profile->dob }}" class="form-control" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Place of Birth</label>
                                <input type="text" name="pob" value="{{ $user->profile->pob }}" class="form-control" placeholder="Enter Place of Birth">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Passport Number</label>
                                <input type="text" name="passport_number" value="{{ $user->profile->passport }}" class="form-control" placeholder="Enter Passport Number">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Passport Expiry Date</label>
                                <input type="date" name="passport_expiry" value="{{ $user->profile->passport_expiry }}" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Profession</label>
                                <input type="text" name="profession" value="{{ $user->profile->profession }}" class="form-control" placeholder="Enter Profession">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>First Language</label>
                                <input type="text" name="language" value="{{ $user->profile->language }}" class="form-control" placeholder="Enter First Language">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Preferred Country of Migration/Study</label>
                                <input type="text" name="country" value="{{ $user->profile->country }}" class="form-control" placeholder="Enter Preferred Country of Migration/Study">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Street Address</label>
                                <input type="text" name="street_address" value="{{ $user->profile->street }}" class="form-control" placeholder="Enter Street Address">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" value="{{ $user->profile->city }}" class="form-control" placeholder="Enter City">
                            </div>
                        </div>
                    </div><hr>
                    <div class="text-danger">EMERGENCY INFO</div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Emergency Contact Person</label>
                                <input type="text" name="emergency" value="{{ $user->emergency->name }}" class="form-control" placeholder="Enter Emergency Contact Person">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Emergency Phone</label>
                                <input type="text" name="emergency_phone" maxlength="10" value="{{ $user->emergency->phone }}" class="form-control" placeholder="Enter Emergency Phone Number">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Emergency Address</label>
                                <input type="text" name="emergency_address" value="{{ $user->emergency->address }}" class="form-control" placeholder="Enter Emergency Address">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary px-5 btn_addnew"><i class="fa fa-refresh"></i> Update Client</button>
                   </div>
                </form>
            </div>            
        </div>
      </div>
    </div>
  </div><!-- End Row-->

@endsection
@section('scripts')   
<script>
$("#formAddNew").on("submit", function(e){
    e.stopPropagation();
    $('.btn_addnew').html('<i class="fa fa-spinner fa-spin"></i> Updating Client...').attr('disabled', true);
    return true;
});

</script>  
@endsection