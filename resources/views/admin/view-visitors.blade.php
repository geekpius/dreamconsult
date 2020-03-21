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
        <h4 class="page-title">Perform this activities on visitor module</h4>
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
            View All Old Visitors
            <a href="{{ route('admin.viewstudent.incomplete') }}" class="ml-5">Current Visitors</a>
       </div>
        <div class="card-body">
          <div class="table-responsive">
          <table id="example" class="table table-striped table-borderless">
            <thead>
                <tr>
                    <th>Reg. Date</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>                    
                    <th>Services</th>                    
                    <th>Branch</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @if (count($visitors))
            @foreach($visitors as $vis)
                <tr class="records">
                    <td class="text-danger">{{ \Carbon\Carbon::parse($vis->created_at)->format('d-M-Y') }}</td>
                    <td>{{ $vis->first_name }}</td>
                    <td>{{ $vis->last_name }}</td>
                    <td><a href="mailto:{{ $vis->email }}" target="_blank">{{ $vis->email }}</a></td>
                    <td><a href="tel:{{ $vis->phone }}" target="_blank">{{ $vis->phone }}</a></td>
                    <td>{{ $vis->service }}</td>
                    <td>{{ $vis->branch }}</td>
                    <td>
                        {{-- <a href="javascript:void();" title="Edit" data-toggle="tooltip" class="text-primary btn_edit" data-id="{{ $vis->id }}" data-phone="{{ $vis->phone }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp; --}}
                        <a href="javascript:void();" title="Delete" data-toggle="tooltip" data-href="{{ route('admin.visitor.delete', $vis->id) }}" class="text-danger btn_delete"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
            @endif    
            </tbody>
            <tfoot>
                <tr>
                    <th>Reg. Date</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>                    
                    <th>Services</th>                    
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


<!-- Modal -->
{{-- <div class="modal fade" id="EditVisitorModal">
    <div class="modal-dialog">
        <div class="modal-content animated zoomInUp">
            <div class="modal-header">
            <h5 class="modal-title">Edit Visitor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="formEditNew" method="POST" action="{{ route('admin.visitor.update') }}">
                    @csrf
                    <input type="hidden" name="visitor_id" id="visitor_id" readonly>
                    <div class="form-group validate">
                        <label for="input-1">First Name</label>
                        <input type="text" name="first_name" class="form-control" placeholder="Enter First Name">
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group validate">
                        <label for="input-1">Last Name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name">
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group validate">
                        <label for="input-1">Phone Number</label>
                        <input type="text" name="phone_number" maxlength="10" class="form-control" placeholder="Enter Phone Number">
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block px-5 btn_editnew"><i class="fa fa-refresh"></i> Update</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div> --}}

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
                title: 'VISITORS',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,6 ]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,6 ]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'VISITORS',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,6 ]
                }
            },
            {
                extend: 'print',
                title: 'VISITORS',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,6 ]
                }
            },
            'colvis'
        ]
} );

table.buttons().container()
.appendTo( '#example_wrapper .col-md-6:eq(0)' );


$("#formEditNew").on("submit", function(e){
    e.stopPropagation();
    var valid = true;
    $('#formEditNew input').each(function() {
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


//edit
$("#example tbody").on('click', '.btn_edit', function(e){
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $("#visitor_id").val($this.data('id'));
    $("#formEditNew input[name='first_name']").val($this.parents('.records').find('td').eq(1).text());
    $("#formEditNew input[name='last_name']").val($this.parents('.records').find('td').eq(2).text());
    $("#formEditNew input[name='phone_number']").val($this.data('phone'));
    $("#EditVisitorModal").modal({backdrop: 'static'});
    return false;
});

$("#example tbody").on('click', '.btn_delete', function(e){
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