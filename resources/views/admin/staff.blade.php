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
        <h4 class="page-title">Perform this activities on staff module</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">View</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Add New</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Edit</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Transfer</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Block/Unblock</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Delete</a></li>
        </ol>
    </div>
</div>
<!-- End Breadcrumb-->
 

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
            <button type="button" data-toggle="modal" data-target="#AddUserModal" data-backdrop="static" class="btn btn-primary btn-round waves-effect waves-light m-1"><i class="fa fa-plus-circle"></i> ADD NEW STAFF</button>
       </div>
        <div class="card-body">
          <div class="table-responsive">
          <table id="example" class="table table-striped table-borderless">
            <thead>
                <tr>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Staff Type</th>
                    <th>Branch</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($staff))
                @foreach($staff as $user)
                <tr class="records">
                    <td>{{ $user->name }}</td>
                    <td><a href="mailto:{{ $user->email }}" target="_blank">{{ $user->email }}</a></td>
                    <td><a href="tel:{{ $user->phone }}" target="_blank">{{ $user->phone }}</a></td>
                    <td>{{ ucwords($user->role) }}</td>
                    <td>{{ $user->branch }}</td>
                    <td>{{ ($user->active)? 'Yes':'No' }}</td>
                    <td>
                        <a href="javascript:void();" title="Edit" data-toggle="tooltip" class="text-primary btn_edit" data-role="{{ $user->role }}" data-id="{{ $user->id }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                        <a href="javascript:void();" title="Transfer staff" data-toggle="tooltip" class="text-warning btn_transfer" data-id="{{ $user->id }}"><i class="fa fa-exchange"></i></a>&nbsp;&nbsp;
                        <a href="javascript:void();" title="{{ ($user->active)? 'Block':'Unblock' }} staff" data-toggle="tooltip" data-href="{{ route('admin.staff.block', $user->id) }}" data-id="{{ $user->active }}" class="{{ ($user->active)? 'text-danger':'text-success' }} btn_block"><i class="fa {{ ($user->active)? 'fa-ban':'fa-check-circle' }}"></i></a>&nbsp;&nbsp;
                        <a href="javascript:void();" title="Delete staff" data-toggle="tooltip" data-href="{{ route('admin.staff.delete', $user->id) }}" class="text-danger btn_delete"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th>Fullname</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Staff Type</th>
                    <th>Branch</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
        </div>
        </div>
      </div>
    </div>
  </div><!-- End Row-->


<!-- Modal -->
<div class="modal fade" id="AddUserModal">
    <div class="modal-dialog">
        <div class="modal-content animated zoomInUp">
            <div class="modal-header">
            <h5 class="modal-title">Add New Staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="formAddNew" method="POST" action="{{ route('admin.staff.submit') }}">
                    @csrf
                    <div class="form-group validate">
                        <label for="input-1">Full Name</label>
                        <input type="text" name="fullname" class="form-control" id="fullname" oninput="GetUpperCase('fullname');" placeholder="Enter Full Name">
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group validate">
                        <label for="input-2">Email</label>
                        <input type="email" name="email" class="form-control" id="input-2" placeholder="Enter Email Address">
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group validate">
                        <label for="input-1">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number">
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group validate">
                        <label for="input-3">Staff Type</label>
                        <select name="staff_type" class="form-control" id="basic-select staff_type">
                            <option value="">-Select-</option>
                            <option value="front desk">Front Desk</option>
                            <option value="tutor">Tutor</option>
                        </select>
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group validate">
                        <label for="input-3">Branch</label>
                        <select name="branch" class="form-control" id="basic-select branch">
                            <option value="">-Select-</option>
                            @if (count($branches))
                            @foreach ($branches as $b)
                            <option value="{{ $b->name }}">{{ $b->name }}</option>                                
                            @endforeach  
                            @endif
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

<div class="modal fade" id="EditUserModal">
    <div class="modal-dialog">
        <div class="modal-content animated zoomInUp">
            <div class="modal-header">
            <h5 class="modal-title">Edit Staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="formEditNew" method="POST" action="{{ route('admin.staff.update') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" readonly>
                    <div class="form-group validate">
                        <label for="input-1">Full Name</label>
                        <input type="text" name="fullname" class="form-control" id="fullname1" oninput="GetUpperCase('fullname1');" placeholder="Enter Full Name">
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group validate">
                        <label>Staff Type</label>
                        <select name="staff_type" class="form-control" id="staff_type1">
                            <option value="front desk">Front Desk</option>
                            <option value="tutor">Tutor</option>
                        </select>
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block px-5 btn_editnew"><i class="fa fa-refresh"></i> Update</button>
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
            <h5 class="modal-title">Transfer Staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="formTransfer" method="POST" action="{{ route('admin.staff.transfer') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" readonly>
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
    buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ]
} );

table.buttons().container()
.appendTo( '#example_wrapper .col-md-6:eq(0)' );


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
        $('.btn_addnew').html('<i class="fa fa-spinner fa-spin"></i> Submitting...').attr('disabled', true);
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

//edit
$('.btn_edit').on('click', function(e){
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $("#user_id").val($this.data('id'));
    $("#staff_type1").val($this.data('role'));
    $("#formEditNew input[name='fullname']").val($this.parents('.records').find('td').eq(0).text());
    $("#EditUserModal").modal({backdrop: 'static'});
    return false;
});


$("#formEditNew").on("submit", function(e){
    e.stopPropagation();
    var valid = true;
    $('#formEditNew input, #formEditNew select').each(function() {
        var $this = $(this);
        
        if(!$this.val()) {
            valid = false;
            $this.parents('.validate').find('span').text('The '+$this.attr('name').replace(/[\_]+/g, ' ')+' field is required');
        }
    });
    if(valid) {
        $('.btn_editnew').html('<i class="fa fa-spinner fa-spin"></i> Updating...').attr('disabled', true);
        return true;
    }
    return false;
});

$("#formEditNew input").on('input', function(){
    if($(this).val()!=''){
        $(this).parents('.validate').find('span').text('');
    }else{ $(this).parents('.validate').find('span').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required'); }
});

//transfer
$('.btn_transfer').on('click', function(e){
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $("#formTransfer #user_id").val($this.data('id'));
    $("#formTransfer #branch1").val($this.parents('.records').find('td').eq(4).text());
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

$('.btn_block').on('click', function(e){
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    var $href = $this.data('href');
    swal({
        title: "Are you sure?",
        text: "You are about to "+(($this.data('id')==1)? 'block':'unblock')+" user.",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass:  (($this.data('id')==1)? 'btn-danger':'btn-success')+" btn-sm",
        cancelButtonClass: "btn-sm",
        confirmButtonText: "Yes, "+(($this.data('id')==1)? 'block':'unblock'),
        closeOnConfirm: false
        },
    function(){
        window.location = $href;
    });
    return false;
});


$('.btn_delete').on('click', function(e){
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

function GetUpperCase(field){
    var set_field = document.getElementById(field).value;
    document.getElementById(field).value=set_field.toUpperCase();
}
</script>  
@endsection