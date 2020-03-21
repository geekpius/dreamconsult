@extends('layouts.admin')
@section('style')  
@endsection
@section('content')
<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Perform this activities on registration module</h4>
    </div>
</div>
<!-- End Breadcrumb-->
 

  <div class="row">

    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
           Registering <span class="text-primary mr-5">{{ $user->first_name }}</span> 
       </div>
        <div class="card-body row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <span class="text-primary"><strong>{{ $user->first_name }} {{ $user->last_name }} - {{ $user->branch }} BRANCH </strong></span><br>
                <hr>
                @if(!$user->discount_check)
                  <div class="form-group mb-5 mt-5">
                      <a href="{{ route('admin.student') }}" class="btn btn-warning px-5 btn-block"><i class="fa fa-spin fa-spinner"></i> Waiting for Discount Approval</a>
                  </div>
                @else
                <div class="form-group mb-5 mt-5">
                    <a href="{{ route('admin.receivepay', $user->id) }}" class="btn btn-success px-5 btn-block"><i class="fa fa-user-circle-o"></i> Continue as Client</a>
                </div>
                <div class="form-group">
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#commentModal" class="btn btn-primary px-5 btn-block"><i class="fa fa-user"></i> Continue as Visitor</a>
                    {{-- <a href="{{ route('admin.viewstudent.incomplete') }}" class="btn btn-primary px-5 btn-block"><i class="fa fa-user"></i> Continue as Visitor</a><a href="{{ route('admin.viewstudent.incomplete') }}" class="btn btn-primary px-5 btn-block"><i class="fa fa-user"></i> Continue as Visitor</a> --}}
                </div>
              @endif
            </div>            
        </div>
      </div>
    </div>
  </div><!-- End Row-->


<div class="modal fade" id="commentModal">
  <div class="modal-dialog modal-sm">
      <div class="modal-content animated zoomInUp">
          <div class="modal-header">
          <h5 class="modal-title">Additional Information</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body">
              <form id="formComment" method="POST" action="{{ route('admin.visitor.comment.update', $user->id) }}">
                  @csrf
                  <div class="form-group validate">
                      <label>Additional Info</label>
                      <textarea name="additional_info" id="additional_info" cols="30" rows="5" class="form-control"></textarea>
                      <span class="small mySpan text-danger"></span>
                  </div>
                  <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-block px-5 btnComment"><i class="fa fa-dot-circle-o"></i> Continue</button>
              </div>
          </form>
          </div>
      </div>
  </div>
</div>



@endsection
@section('scripts')   
<script>
  $("#formComment").on("submit", function(e){
    e.stopPropagation();
    if($("#additional_info").val()==''){
      $("#additional_info").parents('.validate').find(".mySpan").text('The additional info field is required');
    }
    else{
      $(".btnComment").html('<i class="fa fa-spin fa-spinner"></i> Processing...');
      return true;
    }
    return false;
  });
</script>
@endsection