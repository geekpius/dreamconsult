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
        <h4 class="page-title">Perform this activities on payment module</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">View</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Receive Payment</a></li>
        </ol>
    </div>
</div>
<!-- End Breadcrumb-->
 

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
            View All Defaulters
       </div>
        <div class="card-body">
          <div class="table-responsive">
          <table id="example" class="table table-striped table-borderless">
            <thead>
                <tr>
                    <th>Client ID</th>                    
                    <th>First Name</th>
                    <th>Last Name</th>                  
                    <th>Branch</th>                  
                    <th>Amount Owe<small>(GH&#x20B5;)</small></th>          
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @if (count($users))
            @foreach($users as $vis)
                <tr class="records">
                    <td>{{ $vis->student_id }}</td>
                    <td>{{ $vis->first_name }}</td>
                    <td>{{ $vis->last_name }}</td>
                    <td>{{ $vis->branch }}</td>
                    <td class="text-danger">{{ number_format($vis->balance,2) }}</td>
                    <td>
                        <a href="{{ route('admin.receivepay', $vis->id) }}" title="Receive Payment" data-toggle="tooltip" class="text-success btn_receive"><i class="fa fa-money"></i> Receive</a>
                    </td>
                </tr>
            @endforeach
            @endif    
            </tbody>
            <tfoot>
                <tr>
                    <th>Client ID</th>                    
                    <th>First Name</th>
                    <th>Last Name</th>                 
                    <th>Branch</th>                 
                    <th>Amount Owe<small>(GH&#x20B5;)</small></th>          
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
var table = $('#example').DataTable();

table.buttons().container()
.appendTo( '#example_wrapper .col-md-6:eq(0)' );

</script>  
@endsection