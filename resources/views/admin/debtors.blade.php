@extends('layouts.admin')
@section('style')
<!--Data Tables -->
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">   
@endsection
@section('content')
<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Perform this activities on debtor module</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">View</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">filter</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">list</a></li>
        </ol>
    </div>
</div>
<!-- End Breadcrumb-->
 

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
            <strong>All Debtors</strong>
            <a href="javascript:void(0);" class="btn btn-primary px-4 ml-5 btn-sm btn_send"><i class="fa fa-envelope"></i> SEND REMINDER EMAIL</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-borderless">
                    <thead>
                        <tr>
                            <th>
                                <div class="icheck-material-primary" style="margin: 0xp !important">
                                    <input type="checkbox" name="parent" id="chkParent">
                                    <label for="chkParent"></label>
                                </div>
                            </th> 
                            <th>Reg. Date</th> 
                            <th>Client ID</th>                    
                            <th>First Name</th>
                            <th>Last Name</th>                        
                            <th>Balance<small>(GH&#x20B5;)</small></th>  
                        </tr>
                    </thead>
                    <tbody>
                    @php $total_owe = 0; @endphp
                    @if (count($debtors))
                    @foreach ($debtors as $debt)
                    @php $total_owe += $debt->balance; @endphp
                        <tr>
                            <td>
                                <div class="icheck-material-primary" style="margin: 0xp !important">
                                    <input type="checkbox" id="{{ $debt->id }}" value="{{ $debt->id }}">
                                    <label for="{{ $debt->id }}"></label>
                                </div>
                            </td>
                            <td> {{ \Carbon\Carbon::parse($debt->created_at)->format('d-M-Y') }} </td>
                            <td class="text-primary"> {{ $debt->student_id }} </td>
                            <td> {{ $debt->first_name }} </td>
                            <td> {{ $debt->last_name }} </td>
                            <td class="text-danger"> {{ number_format($debt->balance,2) }} </td>
                        </tr>
                    @endforeach    
                    @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>                    
                            <th>Reg. Date</th>                    
                            <th>Client ID</th>                    
                            <th>First Name</th>
                            <th>Last Name</th>                             
                            <th>Balance<small>(GH&#x20B5;)</small></th>      
                        </tr>
                    </tfoot>
                </table>
                <span class="text-danger"><strong>Total Amount Owe: GH&#x20B5; {{ number_format($total_owe,2) }}</strong></span>
                
            </div>
        </div>
      </div>
    </div>
  </div><!-- End Row-->

@endsection
@section('scripts')   
<!--Data Tables js-->
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js') }}"></script>
<script>
var table = $('#example').DataTable( {
    lengthChange: false,
    buttons: [
            {
                extend: 'excelHtml5',
                title: 'DEBTORS',
                exportOptions: {
                    columns: [ 1, 2, 3,4, 5 ]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 1, 2, 3,4, 5 ]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'DEBTORS',
                exportOptions: {
                    columns: [ 1, 2, 3,4, 5 ]
                }
            },
            {
                extend: 'print',
                title: 'DEBTORS',
                exportOptions: {
                    columns: [ 1, 2, 3,4, 5 ]
                }
            },
            'colvis'
        ]
} );

table.buttons().container()
.appendTo( '#example_wrapper .col-md-6:eq(0)' );


$('#chkParent').on("click", function() {
    var isChecked = $(this).prop("checked");
    $('#example tr:has(td)').find('input[type="checkbox"]').prop('checked', isChecked);
});

$('#example tr:has(td)').find('input[type="checkbox"]').on("click", function() {
    var isChecked = $(this).prop("checked");
    var isHeaderChecked = $("#chkParent").prop("checked");
    if (!isChecked && isHeaderChecked)
        $("#chkParent").prop('checked', isChecked);
    else {
        $('#example tr:has(td)').find('input[type="checkbox"]').each(function() {
            if (!$(this).prop("checked"))
                isChecked = false;
        });
        $("#chkParent").prop('checked', isChecked);
    }
}); 

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
})

$(".btn_send").on('click', function(e){
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    var $href = $this.data('href');
    var isChecked = 0;
    var ids = [];
    $('#example tr:has(td)').find('input[type="checkbox"]').each(function() {
        if ($(this).prop("checked")){
            isChecked +=1;
            ids.push($(this).val());
        }
    });
    if(isChecked==0){
        swal({
            title: "No Selection",
            text: "Select clients to send reminder",
            type: "error",
            showCancelButton: false,
            confirmButtonClass: "btn-primary btn-sm",
            confirmButtonText: "OKAY",
            closeOnConfirm: true
        });
    }else{
        var data = {ids:ids};
        swal({
            title: "Sure to send?",
            text: "You are about to send email reminder to "+isChecked.toString()+" clients",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-primary btn-sm",
            cancelButtonClass: "btn-sm",
            confirmButtonText: "Yes, send",
            closeOnConfirm: true
            },
        function(){
            $this.html('<i class="fa fa-spinner fa-spin"></i> Sending Email.. Please wait..').addClass('disabled');
            $.ajax({
                url: "{{ route('admin.debtors.sendreminder') }}",
                type: "POST",
                data: data,
                success: function(resp){
                    if(resp=='error'){
                        swal({
                            title: "Opps",
                            text: "Something went wrong",
                            type: "error",
                            showCancelButton: false,
                            confirmButtonClass: "btn-primary btn-sm",
                            confirmButtonText: "OKAY",
                            closeOnConfirm: true
                        });
                    }
                    else{
                        swal({
                            title: "Sent",
                            text: resp,
                            type: "success",
                            showCancelButton: false,
                            confirmButtonClass: "btn-primary btn-sm",
                            confirmButtonText: "OKAY",
                            closeOnConfirm: true
                        });
                    }
                    
                    $this.html('<i class="fa fa-envelope"></i> SEND REMINDER EMAIL').removeClass('disabled');
                },
                error: function(resp){
                    alert('Something went wrong with your request');
                    $this.html('<i class="fa fa-envelope"></i> SEND REMINDER EMAIL').removeClass('disabled');
                }
            });
        });
   }
    return false;
});

</script>  
@endsection