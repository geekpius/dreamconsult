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
        <h4 class="page-title">Perform this activities on client module</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">View</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Edit</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Delete</a></li>
        </ol>
    </div>
</div>
<!-- End Breadcrumb-->
 

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
            View All Clients
       </div>
        <div class="card-body">
          <div class="table-responsive">
          <table id="example" class="table table-striped table-borderless">
            <thead>
                <tr>
                    <th>Reg. Date</th> 
                    <th>Client ID</th>                    
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>              
                    <th>Branch</th>          
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @if (count($users))
            @foreach($users as $vis)
                <tr class="records">
                    <td class="text-danger">{{ \Carbon\Carbon::parse($vis->created_at)->format('d-M-Y') }}</td>
                    <td class="text-success">{{ $vis->student_id }}</td>
                    <td>{{ $vis->first_name }}</td>
                    <td>{{ $vis->last_name }}</td>
                    <td><a href="mailto:{{ $vis->email }}" target="_blank">{{ $vis->email }}</a></td>
                    <td><a href="tel:{{ $vis->phone }}" target="_blank">{{ $vis->phone }}</a></td>
                    <td>{{ $vis->branch }}</td>
                    <td>
                        <a href="{{ route('admin.student.info', $vis->id) }}" title="View Info" data-toggle="tooltip" class="text-primary"><i class="fa fa-user"></i></a>&nbsp;&nbsp;
                        <a href="{{ route('admin.student.service', $vis->id) }}" title="List Services" data-toggle="tooltip" class="text-warning"><i class="fa fa-list-ul"></i></a>&nbsp;&nbsp;
                        <a href="javascript:void(0);" data-id="{{ $vis->id }}" data-branch="{{ $vis->branch }}" title="Add Service" data-toggle="tooltip" class="text-secondary btn_service"><i class="fa fa-plus-circle"></i></a>&nbsp;&nbsp;
                        <a href="{{ route('admin.student.edit', $vis->id) }}" title="Edit" data-toggle="tooltip" class="text-primary"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                        @if (Auth::user()->role=='administrator' || Auth::user()->role=='developer' || Auth::user()->role=='operations')
                        <a href="javascript:void();" title="Transfer client" data-toggle="tooltip" class="text-warning btn_transfer" data-id="{{ $vis->id }}"><i class="fa fa-exchange"></i></a>&nbsp;&nbsp;
                        @endif
                        @if (Auth::user()->role=='administrator' || Auth::user()->role=='developer')
                        <a href="javascript:void();" title="Delete" data-toggle="tooltip" data-href="{{ route('admin.student.delete', $vis->id) }}" class="text-danger btn_delete"><i class="fa fa-trash"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
            @endif    
            </tbody>
            <tfoot>
                <tr>
                    <th>Reg. Date</th>                    
                    <th>Client ID</th>                    
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>              
                    <th>Branch</th>            
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
        </div>
        </div>
      </div>
    </div>
  </div><!-- End Row-->



<div class="modal fade" id="AddServiceModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated zoomInUp">
            <div class="modal-header">
            <h5 class="modal-title">Add New Service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="formAddNew" method="POST" action="{{ route('admin.student.addservice.submit') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" readonly>
                    <input type="hidden" name="branch" id="branch" readonly>
                    <div class="form-group validate">
                        <label>Service<i class="text-danger">*</i></label>
                        <select name="service" class="form-control" id="service">
                            <option value="">-Select-</option>
                            @foreach ($services as $service)
                            <option value="{{ $service->name }}">{{ $service->name }}</option>                                        
                            @endforeach
                        </select>
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    
                    <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block px-5 btn_addnew"><i class="fa fa-save"></i> Submit</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="TransferModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated zoomInUp">
            <div class="modal-header">
            <h5 class="modal-title">Transfer Client</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="formTransfer" method="POST" action="{{ route('admin.student.transfer') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id1" readonly>
                    <div class="form-group validate">
                        <label>Branch</label>
                        <select name="branch" class="form-control" id="branch1">
                            @if (count($branches))
                            @foreach($branches as $br)
                            <option value="{{ $br->name }}">{{ $br->name }}</option>
                            @endforeach
                            @endif
                        </select>
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block px-5 btn_send_transfer"><i class="fa fa-exchange"></i> Transfer</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

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
                title: 'REGISTERED CLIENTS',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6 ]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6 ]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'REGISTERED CLIENTS',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6 ]
                }
            },
            {
                extend: 'print',
                title: 'REGISTERED CLIENTS',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6 ]
                }
            },
            'colvis'
        ]
} );

table.buttons().container()
.appendTo( '#example_wrapper .col-md-6:eq(0)' );

$("#example tbody").on('click', '.btn_service', function(){
    var $this = $(this);
    $('#formAddNew #user_id').val($this.data('id'));
    $('#formAddNew #branch').val($this.data('branch'));
    $("#AddServiceModal").modal({backdrop: 'static'});
    return false;
});


$("#formAddNew").on("submit", function(e){
    e.stopPropagation();
    var valid = true;
    $('#formAddNew select').each(function() {
        var $this = $(this);
        
        if(!$this.val()) {
            valid = false;
            $this.parents('.validate').find('span').text('The '+$this.attr('name').replace(/[\_]+/g, ' ')+' field is required');
        }
    });
    if(valid) {
        $('.btn_addnew').html('<i class="fa fa-spinner fa-spin"></i> Submitting...').attr('disabled', true);
        return true;
    }
    return false;
});

$("#formAddNew select").on('change', function(){
    if($(this).val()!=''){
        $(this).parents('.validate').find('span').text('');
    }else{ $(this).parents('.validate').find('span').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required'); }
});


//transfer
$('#example tbody').on('click', '.btn_transfer', function(e){
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $("#formTransfer #user_id1").val($this.data('id'));
    $("#formTransfer #branch1").val($this.parents('.records').find('td').eq(6).text());
    $("#TransferModal").modal({backdrop: 'static'});
    return false;
});

$("#formTransfer").on("submit", function(e){
    e.stopPropagation();
    var valid = true;
    $('#formTransfer select').each(function() {
        var $this = $(this);
        
        if(!$this.val()) {
            valid = false;
            $this.parents('.validate').find('span').text('The '+$this.attr('name').replace(/[\_]+/g, ' ')+' field is required');
        }
    });
    if(valid) {
        $('.btn_send_transfer').html('<i class="fa fa-spinner fa-spin"></i> Transfering...').attr('disabled', true);
        return true;
    }
    return false;
});

$('#example tbody').on('click', '.btn_delete', function(e){
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    var $href = $this.data('href');
    swal({
        title: "Sure to delete?",
        text: "This action is irreversible",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger btn-sm",
        cancelButtonClass: "btn-sm",
        confirmButtonText: "Yes, delete",
        closeOnConfirm: false
        },
    function(){
        window.location = $href;
    });
    return false;
});
</script>  
@endsection