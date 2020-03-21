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
        <h4 class="page-title">Perform this activities on service module</h4>
    </div>
</div>
<!-- End Breadcrumb-->
 

  <div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
            List Services &nbsp;&nbsp;||&nbsp;&nbsp;
            <a href="{{ route('admin.viewstudent') }}">Go Back</a> 
       </div>
        <div class="card-body">
          <div class="table-responsive">
          <table id="example" class="table table-striped table-borderless">
            <thead>
                <tr>
                    <th>Service</th>                    
                    <th>Amount Payble<small>(GH&#x20B5;)</small></th>             
                    <th>Amount Paid<small>(GH&#x20B5;)</small></th>             
                    <th>Amount Left<small>(GH&#x20B5;)</small></th>   
                </tr>
            </thead>
            <tbody>
            @php $total_payable = 0; $total_paid = 0; $total_owe = 0; @endphp
            @if (count($services))
            @foreach($services as $service)
            @php $total_payable += $service->payable; $total_paid += $service->paid; $total_owe += ($service->payable-$service->paid); @endphp
                <tr class="records">
                    <td>{{ $service->type }}</td>
                    <td class="text-primary">{{ number_format($service->payable,2) }}</td>
                    <td class="text-success">{{ number_format($service->paid,2) }}</td>
                    <td class="text-danger">{{ number_format(($service->payable-$service->paid),2) }}</td>
                </tr>
            @endforeach
            @endif    
            </tbody>
            <tfoot>
                <tr>
                    <th>Service</th>                    
                    <th>Amount Payble<small>(GH&#x20B5;)</small></th>               
                    <th>Amount Paid<small>(GH&#x20B5;)</small></th>               
                    <th>Amount Left<small>(GH&#x20B5;)</small></th>     
                </tr>
            </tfoot>
        </table>
        
            <span class="text-primary mr-3"><strong>Total Payable: GH&#x20B5; {{ number_format($total_payable,2) }} </strong></span>
            <span class="text-success mr-3"><strong>Total Paid: GH&#x20B5; {{ number_format($total_paid,2) }} </strong></span>
            <span class="text-danger"><strong>Total Left: GH&#x20B5; {{ number_format($total_owe,2) }}</strong></span>
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
                title: "{{ $page_title }}",                
                messageTop: "{{ $page_title }} And Payments",
                exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                }
            },
            {
                extend: 'print',
                title: "{{ $page_title }}",                
                messageTop: "{{ $page_title }} And Payments",
                exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                }
            }
        ]
} );

table.buttons().container()
.appendTo( '#example_wrapper .col-md-6:eq(0)' );
</script>  
@endsection