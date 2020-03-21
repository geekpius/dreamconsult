@extends('layouts.admin')
@section('style')  
@endsection
@section('content')
<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Perform this activities on employees module</h4>
    </div>
</div>
<!-- End Breadcrumb-->
 

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
            Taxes
        </div>
        <div class="card-body row">
            <div class="col-sm-4">
                <form id="formAddNew">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group validate">
                                <label>Tax (%)<i class="text-danger">*</i></label>
                                <input type="text" name="tax" value="{{ empty($tax->tax)? 0:$tax->tax }}" class="form-control" placeholder="Enter Tax Percentage">
                                <span class="text-danger small" role="alert"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group validate">
                                <label>SNNIT (%)<i class="text-danger">*</i></label>
                                <input type="text" name="ssnit" value="{{ empty($tax->snnit)? 0:$tax->snnit }}" class="form-control" placeholder="Enter Snnit Percentage">
                                <span class="text-danger small" role="alert"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group validate">
                                <label>Other (%)<i class="text-danger">*</i></label>
                                <input type="text" name="other" value="{{ empty($tax->other)? 0:$tax->other }}" class="form-control" placeholder="Enter Other Deduction in Percentage">
                                <span class="text-danger small" role="alert"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary px-5 btn_addnew"><i class="fa fa-refresh"></i> Update</button>
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
$('#tax, #snnit, #other').keypress(function(event) {
    if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
            $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
}).on('paste', function(event) {
    event.preventDefault();
});  

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
})


$("#formAddNew").on("submit", function(e){
    e.stopPropagation();
    var valid = true;
    $('#formAddNew input').each(function() {
        var $this = $(this);
        
        if(!$this.val()) {
            valid = false;
            $this.parents('.validate').find('span').text('The '+$this.attr('name').replace(/[\_]+/g, ' ')+' field is required');
        }
    });
    if(valid) {
        $('.btn_addnew').html('<i class="fa fa-spin fa-spinner"></i> Updating...').attr('disabled', true);
        var data = $("#formAddNew").serialize();
        $.ajax({
            url: "{{ route('admin.employees.taxes.submit') }}",
            type: "POST",
            data: data,
            success: function(resp){
                if(resp=='success'){
                    swal({
                        title: "Updated",
                        text: "Taxes updated successful",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonClass: "btn-primary btn-sm",
                        confirmButtonText: "OKAY",
                        closeOnConfirm: true
                    });
                }
                else{
                    swal({
                        title: "Opps",
                        text: resp,
                        type: "error",
                        showCancelButton: false,
                        confirmButtonClass: "btn-primary btn-sm",
                        confirmButtonText: "OKAY",
                        closeOnConfirm: true
                    });
                }
                $('.btn_addnew').html('<i class="fa fa-refresh"></i> Update').attr('disabled', false);
            },
            error: function(resp){
                alert('Something went wrong with request');
                $('.btn_addnew').html('<i class="fa fa-refresh"></i> Update').attr('disabled', false);
            }
        });                     
    }
    return false;
});
</script>  
@endsection