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
        <h4 class="page-title">Perform this activities on full payers module</h4>
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
            <strong>All Full Payers</strong>
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
                        </tr>
                    </thead>
                    <tbody>
                    @if (count($debtors))
                    @foreach ($debtors as $debt)
                        <tr>
                            <td> {{ \Carbon\Carbon::parse($debt->created_at)->format('d-M-Y') }} </td>
                            <td class="text-primary"> {{ $debt->student_id }} </td>
                            <td> {{ $debt->first_name }} </td>
                            <td> {{ $debt->last_name }} </td>
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
                title: 'FULL PAYERS',
                exportOptions: {
                    columns: [0, 1, 2, 3 ]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3 ]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'FULL PAYERS',
                exportOptions: {
                    columns: [0, 1, 2, 3 ]
                }
            },
            {
                extend: 'print',
                title: 'FULL PAYERS',
                exportOptions: {
                    columns: [0, 1, 2, 3 ]
                }
            },
            'colvis'
        ]
} );

table.buttons().container()
.appendTo( '#example_wrapper .col-md-6:eq(0)' );

</script>  
@endsection