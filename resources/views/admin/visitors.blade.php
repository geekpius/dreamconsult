@extends('layouts.admin')
@section('style')  
@endsection
@section('content')
<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Perform this activities on visitor module</h4>
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
           Add New Visitor
       </div>
        <div class="card-body row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <form id="formAddNew" method="POST" action="{{ route('admin.visitor.submit') }}">
                    @csrf
                    <div class="form-group validate">
                        <label>First Name<i class="text-danger">*</i></label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" placeholder="Enter First Name">
                        <span class="text-danger small" role="alert">{{ $errors->has('first_name') ? $errors->first('first_name') : '' }}</span>
                    </div>
                    <div class="form-group validate">
                        <label>Last Name<i class="text-danger">*</i></label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" placeholder="Enter Last Name">
                        <span class="text-danger small" role="alert">{{ $errors->has('last_name') ? $errors->first('last_name') : '' }}</span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter Email Address">
                    </div>
                    <div class="form-group validate">
                        <label>Phone Number<i class="text-danger">*</i></label>
                        <input type="text" name="phone_number" value="{{ old('phone_number') }}" maxlength="10" class="form-control" placeholder="Enter Phone Numbers">
                        <span class="text-danger small" role="alert">{{ $errors->has('phone_number') ? $errors->first('phone_number') : '' }}</span>
                    </div>
                    <div class="form-group validate">
                        <label>Registration<i class="text-danger">*</i></label>
                        <input type="date" name="registration" value="{{ old('registration') }}" class="form-control" >
                        <span class="text-danger small" role="alert">{{ $errors->has('registration') ? $errors->first('registration') : '' }}</span>
                    </div>
                    <div class="form-group py-2 validate">
                        <label>Services Enquired<i class="text-danger">*</i></label>
                        <div class="row">
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
                        </div>
                        <span class="text-danger small" role="alert">{{ $errors->has('services') ? $errors->first('services') : '' }}</span>
                    </div>
                    @if (Auth::user()->branch=='HEAD OFFICE')
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
                    @endif
                    <div class="form-group">
                        <label>Additional Info</label>
                        <textarea name="additional_info" id="additional_info" rows="3" class="form-control"></textarea>
                  </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary px-5 btn_addnew"><i class="fa fa-plus-circle"></i> Add To Visitor's Book</button>
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
$("#additional_info").val("{{ old('additional_info') }}");

$("#formAddNew").on("submit", function(e){
    e.stopPropagation();
    var valid = true;
    $('#formAddNew :text, #formAddNew select').each(function() {
        var $this = $(this);
        
        if(!$this.val()) {
            valid = false;
            $this.parents('.validate').find('span').text('The '+$this.attr('name').replace(/[\_]+/g, ' ')+' field is required');
        }
    });
    if(valid) {
        $('.btn_addnew').html('<i class="fa fa-spinner fa-spin"></i> Adding To Visitor Book...').attr('disabled', true);
        return true;
    }
    return false;
});

$("#formAddNew input").on('input', function(){
    if($(this).val()!=''){
        $(this).parents('.validate').find('span').text('');
    }else{ $(this).parents('.validate').find('span').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required'); }
});
$("#formAddNew select").on('change', function(){
    if($(this).val()!=''){
        $(this).parents('.validate').find('span').text('');
    }else{ 
        $(this).parents('.validate').find('span').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required');
    }
});
</script>  
@endsection