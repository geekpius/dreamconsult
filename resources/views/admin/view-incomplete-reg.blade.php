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
            View All Visitor Registration
            <a href="{{ route('admin.visitor.viewvisitor') }}" class="ml-5">View Old Visitors</a>
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
                    <th>Additional Info</th>          
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
                    <td>{{ $vis->additional_info }}</td>
                    <td>
                        <a href="{{ route('admin.student.info', $vis->id) }}" title="View Info" data-toggle="tooltip" class="text-primary"><i class="fa fa-user"></i></a>&nbsp;&nbsp;
                        @if(!$vis->discount_check)
                        <a href="javascript:void(0);" title="Waiting for Discount Approval" data-toggle="tooltip" class="text-warning"><i class="fa fa-spin fa-spinner"></i></a>&nbsp;&nbsp;
                        @else
                        <a href="{{ route('admin.receivepay', $vis->id) }}" title="Complete as Client" data-toggle="tooltip" class="text-primary"><i class="fa fa-forward"></i></a>&nbsp;&nbsp;
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
                    <th>Additional Info</th>      
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
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
                title: 'INCOMPLETE CLIENTS REGISTRATION',
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
                title: 'INCOMPLETE CLIENTS REGISTRATION',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6 ]
                }
            },
            {
                extend: 'print',
                title: 'INCOMPLETE CLIENTS REGISTRATION',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6 ]
                }
            },
            'colvis'
        ]
} );

table.buttons().container()
.appendTo( '#example_wrapper .col-md-6:eq(0)' );


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