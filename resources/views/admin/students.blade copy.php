@extends('layouts.admin')
@section('style')  
@endsection
@section('content')
<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Perform this activities on client module</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Add New</a></li>
        </ol>
    </div>
</div>
<!-- End Breadcrumb-->
 

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
           Register New Client
       </div>
        <div class="card-body row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <form id="formAddNew" method="POST" action="{{ route('admin.student.submit') }}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group validate">
                                <label>First Name<i class="text-danger">*</i></label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" placeholder="Enter First Name">
                                <span class="text-danger small" role="alert">{{ $errors->has('first_name') ? $errors->first('first_name') : '' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group validate">
                                <label>Last Name<i class="text-danger">*</i></label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" placeholder="Enter Last Name">
                                <span class="text-danger small" role="alert">{{ $errors->has('last_name') ? $errors->first('last_name') : '' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter Email Address">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group validate">
                                <label>Phone Number<i class="text-danger">*</i></label>
                                <input type="text" name="phone" onkeypress="return isNumber(event);" value="{{ old('phone') }}" maxlength="10" class="form-control" placeholder="Enter Active Phone Number">
                                <span class="text-danger small" role="alert">{{ $errors->has('phone') ? $errors->first('phone') : '' }}</span>
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
                                <input type="date" name="dob" value="{{ old('dob') }}" class="form-control" >
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Place of Birth</label>
                                <input type="text" name="pob" value="{{ old('pob') }}" class="form-control" placeholder="Enter Place of Birth">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Passport Number</label>
                                <input type="text" name="passport_number" value="{{ old('passport_number') }}" class="form-control" placeholder="Enter Passport Number">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Passport Expiry Date</label>
                                <input type="date" name="passport_expiry" value="{{ old('passport_expiry') }}" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Profession</label>
                                <input type="text" name="profession" value="{{ old('profession') }}" class="form-control" placeholder="Enter Profession">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>First Language</label>
                                <input type="text" name="language" value="{{ old('language') }}" class="form-control" placeholder="Enter First Language">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Preferred Country of Migration/Study</label>
                                <input type="text" name="country" value="{{ old('country') }}" class="form-control" placeholder="Enter Preferred Country of Migration/Study">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Street Address</label>
                                <input type="text" name="street_address" value="{{ old('street_address') }}" class="form-control" placeholder="Enter Street Address">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name="city" value="{{ old('city') }}" class="form-control" placeholder="Enter City">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-danger">SERVICE INFO</div>
                    <hr>
                    <div class="row validate">
                        <div class="col-sm-12">
                            <label>Services Enquired<i class="text-danger">*</i></label>
                        </div>
                        @if (count($services))
                        @php $i=0; @endphp
                        @foreach($services as $service)
                        @php $i++; @endphp
                        <div class="col-sm-3">
                            <div class="form-group py-2">
                                <div class="icheck-material-primary">
                                    <input type="checkbox" name="services[]" id="{{ $i }}" value="{{ $service->name }}">
                                    <label for="{{ $i }}">{{ $service->name }}</label>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif    
                        <span class="text-danger small" role="alert">{{ $errors->has('services') ? $errors->first('services') : '' }}</span>
                    </div>
                    @if (Auth::user()->branch=='HEAD OFFICE')
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group validate">
                                <label>Branch<i class="text-danger">*</i></label>
                                <select name="branch" class="form-control" id="branch">
                                    <option value="">-Select-</option>
                                    @if (count($branches))
                                        @foreach($branches as $h)
                                        <option value="{{$h->name}}">{{$h->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="text-danger small" role="alert">{{ $errors->has('branch') ? $errors->first('branch') : '' }}</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group validate">
                                <label>Registration<i class="text-danger">*</i></label>
                                <input type="date" name="registration" value="{{ old('registration') }}" class="form-control" >
                                <span class="text-danger small" role="alert">{{ $errors->has('registration') ? $errors->first('registration') : '' }}</span>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group validate">
                                <label>Registration<i class="text-danger">*</i></label>
                                <input type="date" name="registration" value="{{ old('registration') }}" class="form-control" >
                                <span class="text-danger small" role="alert">{{ $errors->has('registration') ? $errors->first('registration') : '' }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                    <hr>
                    <div class="text-danger">EMERGENCY INFO</div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Emergency Contact Person</label>
                                <input type="text" name="emergency" value="{{ old('emergency') }}" class="form-control" placeholder="Enter Emergency Contact Person">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Emergency Phone</label>
                                <input type="text" name="emergency_phone" onkeypress="return isNumber(event);" maxlength="10" value="{{ old('emergency_phone') }}" class="form-control" placeholder="Enter Emergency Phone Number">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Emergency Address</label>
                                <input type="text" name="emergency_address" value="{{ old('emergency_address') }}" class="form-control" placeholder="Enter Emergency Address">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary px-5 btn_addnew"><i class="fa fa-plus-circle"></i> Register Client</button>
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
$("#branch").val("{{ old('branch') }}");
$("#formAddNew").on("submit", function(e){
    e.stopPropagation();
    if($('#branch').val()==''){
        $('#branch').parents('.validate').find('span').text('The '+$('#branch').attr('name').replace(/[\_]+/g, ' ')+' field is required');
    }
    else{
        $('.btn_addnew').html('<i class="fa fa-spinner fa-spin"></i> Registering Client...').attr('disabled', true);
        return true;
    }
    return false;
});


$("#formAddNew select").on('change', function(){
    if($(this).val()!=''){
        $(this).parents('.validate').find('span').text('');
    }else{ 
        $(this).parents('.validate').find('span').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required');
    }
});

$('#amount_paid').keypress(function(event) {
    if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
            $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
}).on('paste', function(event) {
    event.preventDefault();
});

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

</script>  
@endsection