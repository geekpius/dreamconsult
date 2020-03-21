@extends('layouts.admin')
@section('style')  
@endsection
@section('content')
<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Perform this activities on receive payment module</h4>
    </div>
</div>
<!-- End Breadcrumb-->
 

  <div class="row">

    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
           Receive Payment from <span class="text-primary mr-5">{{ $user->first_name }}</span> 
       </div>
        <div class="card-body row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <form id="formAddNew" method="POST" action="{{ route('admin.receivepay.submit') }}">
                    <span class="text-primary"><strong>{{ $user->first_name }} {{ $user->last_name }} </strong></span><br>
                    <span class="text-danger"><strong>Total payable left for all the {{ count($services) }} services - <small>GH&#x20B5;</small> {{ number_format($user->balance,2) }} </strong></span><br>
                    <span class="text-danger">
                    @foreach ($services as $ser)
                    <strong>{{ $ser->type }} - <small>GH&#x20B5;</small> {{ number_format(($ser->payable-$ser->paid),2) }} </strong> &nbsp;
                    @endforeach
                    </span><hr>
                    @if (!empty($discount))
                        <span class="text-success">
                           You have <small>GH&#x20B5;</small> {{ number_format($discount->amount,2) }} discount for {{ $discount->service }}
                        </span><hr>    
                        <input type="hidden" name="discount" id="discount" value="{{ $discount->amount }}" readonly>                    
                    @endif
                    @csrf
                    <input type="hidden" value="{{ $user->id }}" readonly name="user_id">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group validate">
                                <label>Service paying for<i class="text-danger">*</i></label>
                                <select name="service" class="form-control" id="service">
                                    <option value="">-Select-</option>
                                    @foreach ($services as $service)
                                    <option value="{{ $service->type }}">{{ $service->type }}</option>                                        
                                    @endforeach
                                </select>
                                <span class="text-danger small" role="alert">{{ $errors->has('service') ? $errors->first('service') : '' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group validate">
                                <label>Mode of Payment<i class="text-danger">*</i></label>
                                <select name="mode" class="form-control" id="mode">
                                    <option value="">-Select-</option>
                                    <option value="cash">Cash</option>
                                    <option value="mobile-money">Mobile Money</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                                <span class="text-danger small" role="alert">{{ $errors->has('mode') ? $errors->first('mode') : '' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group validate">
                                <label>Amount paid<i class="text-danger">*</i></label>
                                <input type="text" name="amount" value="{{ old('amount') }}" id="amount" class="form-control" placeholder="Enter Amount">
                                <span class="text-danger small" role="alert">{{ $errors->has('amount') ? $errors->first('amount') : '' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success px-5 btn_addnew"><i class="fa fa-check-circle"></i> Receive Payment</button>
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
$("#service").val("{{ old('service') }}");
$("#mode").val("{{ old('mode') }}");
$("#formAddNew").on("submit", function(e){
    e.stopPropagation();
    var valid = true;
    $('#formAddNew input, #formAddNew select').each(function() {
        var $this = $(this);
        
        if(!$this.val()) {
            valid = false;
            $this.parents('.validate').find('span').text('The '+$this.attr('name').replace(/[\_]+/g, ' ')+' field is required');
        }
    });

    if(valid) {
        $('.btn_addnew').html('<i class="fa fa-spinner fa-spin"></i> Receiving '+$("#service").val()+' Payment...').attr('disabled', true);
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

$("#formAddNew #service").on('change', function(){
    if($(this).val()!=''){
        $('.btn_addnew').html('<i class="fa fa-check-circle"></i> Receive '+$(this).val()+' Payment');
    }else{ 
        $('.btn_addnew').html('<i class="fa fa-check-circle"></i> Receive Payment');
    }
});

$('#amount').keypress(function(event) {
    if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
            $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
}).on('paste', function(event) {
    event.preventDefault();
});
</script>  
@endsection