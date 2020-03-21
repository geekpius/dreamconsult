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
        <h4 class="page-title">Perform this activities on user module</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">View</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Add New</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Edit</a></li>
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
            <button type="button" data-toggle="modal" data-target="#DiscountModal" data-backdrop="static" class="btn btn-primary btn-round waves-effect waves-light m-1"><i class="fa fa-plus-circle"></i> DISCOUNT</button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
          <table id="example" class="table table-striped table-borderless">
            <thead>
                <tr>
                    <th>Client#</th>
                    <th>Fullname</th>
                    <th>Branch</th>
                    <th>Service</th>
                    <th>Amount<small>(GH&#x20B5;)</small></th>
                </tr>
            </thead>
            <tbody>
                @if (count($users))
                @foreach($users as $user)
                <tr class="records">
                    <td class="text-primary">{{ $user->user->student_id }}</td>
                    <td>{{ $user->user->first_name }}&nbsp;{{ $user->user->last_name }}</td>
                    <td>{{ $user->user->branch }}</td>
                    <td>{{ $user->service }}</td>
                    <td class="text-success">{{ number_format($user->amount,2) }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th>Client#</th>
                    <th>Fullname</th>
                    <th>Branch</th>
                    <th>Service</th>
                    <th>Amount<small>(GH&#x20B5;)</small></th>
                </tr>
            </tfoot>
        </table>
        </div>
        </div>
      </div>
    </div>
  </div><!-- End Row-->


<!-- Modal -->
<div class="modal fade" id="DiscountModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated zoomInUp">
            <div class="modal-header">
            <h5 class="modal-title">Give Out Discount</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="formDiscount" method="POST" action="{{ route('admin.discount.submit') }}">
                    @csrf
                    <div class="form-group validate">
                        <label>Client ID#</label>
                        <input type="text" name="client_id" id="client_id" class="form-control" placeholder="Enter Client ID Number">
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group validate">
                        <label>Service</label>
                        <select name="service" class="form-control" id="service">
                            <option value="">-Select-</option>
                            @foreach ($services as $s)
                            <option value="{{ $s->name }}">{{ $s->name }}</option>    
                            @endforeach
                        </select>
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group validate">
                        <label>Amount</label>
                        <input type="text" name="amount" id="amount" class="form-control" placeholder="Enter Discount Amount">
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block px-5 btn_giveout"><i class="fa fa-dot-circle-o"></i> Give Out</button>
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
                title: 'CLIENTS',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'CLIENTS',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            },
            {
                extend: 'print',
                title: 'CLIENTS',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            },
            'colvis'
        ]
} );

table.buttons().container()
.appendTo( '#example_wrapper .col-md-6:eq(0)' );

$("#formDiscount").on("submit", function(e){
    e.stopPropagation();
    var valid = true;
    $('#formDiscount input, #formDiscount select').each(function() {
        var $this = $(this);
        
        if(!$this.val()) {
            valid = false;
            $this.parents('.validate').find('span').text('The '+$this.attr('name').replace(/[\_]+/g, ' ')+' field is required');
        }
    });
    if(valid) {
        $('.btn_giveout').html('<i class="fa fa-spinner fa-spin"></i> Giving Out...').attr('disabled', true);
        return true;
    }
    return false;
});


$("#formDiscount input").on('input', function(){
    if($(this).val()!=''){
        $(this).parents('.validate').find('span').text('');
    }else{ $(this).parents('.validate').find('span').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required'); }
});

$("#formDiscount select").on('change', function(){
    if($(this).val()!=''){
        $(this).parents('.validate').find('span').text('');
    }else{ 
        $(this).parents('.validate').find('span').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required');
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

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
})
$("#client_id").on('input', function(){
    var $this=$(this);
    if($this.val()!=''){
        $.ajax({
            url: "{{ route('admin.discount.checkid') }}",
            type: "POST",
            data: {client_id:$this.val()},
            success: function(resp){
                $this.parent('.validate').find('span').text(resp);
            },
            error: function(resp){
                alert('Something went wrong');
            }
        });
    }
});
</script>  
@endsection