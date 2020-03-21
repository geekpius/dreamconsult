@extends('layouts.admin')
@section('style')  
@endsection
@section('content')
<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Perform this activities on receipt module</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Print</a></li>
        </ol>
    </div>
</div>
<!-- End Breadcrumb-->
 

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
            Receipt 
       </div>
       <div class="card-body">
            <div>
                <div style="margin-left: 25% !important"><a href="javascript:void(0);" id="btn_print"><i class="fa fa-print text-primary fa-lg"></i> Print</a></div>
                <div class="info-bordered small" id="printDiv" style="width: 50% !important; margin-left: 25% !important">
                    <table class="table text-left">
                        <tr class="background-black">
                            <td class="text-center" colspan="3">
                                <img src="{{ asset('assets/images/logos/main-logo.png') }}" alt="Logo" height="32" width="32" class="pull-left">
                                <strong class="text-white" style="font-size: 25px">DREAMS CONSULT</strong>
                            </td>
                        </tr> 
                        <tr>
                            <td class="text-center text-primary" colspan="3"><strong>BRANCHES: </strong> 
                            Achimota-Accra, Adum-Kumasi   
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Official Receipt No#: {{ $payment->receipt_no }}</strong> </td>
                            <td colspan="2">Date: {{ \Carbon\Carbon::parse($payment->created_at)->format('d-M-Y') }}</td>
                        </tr>  
                        <tr>
                            <td colspan="3">Received from:&nbsp;&nbsp; <span>{{ $payment->user->first_name }}&nbsp;{{ $payment->user->last_name }}</span> </td>
                        </tr> 
                        <tr>
                            <td colspan="3">Mobile Number:&nbsp;&nbsp; <span>{{ $payment->user->phone }}</span> </td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-uppercase">A sum of&nbsp; <span> {{ $words }} Ghana cedis {{ $payment->mode }} </span> </td>
                        </tr> 
                        <tr>
                            <td colspan="3">Being&nbsp;&nbsp; <span>{{ ($payment->owe<=0)? 'Balance payment':'Part payment' }} for {{ $payment->service }} </span> </td>
                        </tr> 
                        @if(!empty($payment->discount))
                        <tr>
                            <td colspan="3">You paid GH&#x20B5;&nbsp; {{ number_format(($payment->paid-$payment->discount->amount),2) }} and got a discount of GH&#x20B5;&nbsp; <span>{{ number_format($payment->discount->amount,2) }} </span> </td>
                        </tr> 
                        @endif
                        <tr>
                            <td colspan="3">Balance GH&#x20B5;&nbsp; <span>{{ number_format($payment->owe,2) }} </span> </td>
                        </tr> 
                        <tr>
                            <td><span style="border:solid; border-radius:3px; padding: 1% 4% 1% 4%">GH&#x20B5;&nbsp; {{ number_format($payment->paid,2) }} </span> </td>
                            <td colspan="2">Sign................................</td>
                        </tr> 
                        <tr>
                            <td colspan="3" class="text-center"><strong>Contact:</strong> 0303962074 &nbsp;&nbsp; <strong>Whatsapp:</strong> 0245444499</td>
                        </tr> 
                        <tr>
                            <td colspan="3" class="text-center"><strong>Websit:</strong> www.dreamsconsult.com &nbsp;&nbsp; <strong>Email:</strong> info@dreamsconsult.com</td>
                        </tr> 
                    </table>
                </div>
            </div>

        </div>
       </div>
    </div>
  </div><!-- End Row-->

@endsection
@section('scripts')   
<script src="{{ asset('assets/js/jQuery.print.min.js') }}"></script>
<script>
    $("#btn_print").on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        $("#printDiv").print();
        return false;
    });
</script>
@endsection