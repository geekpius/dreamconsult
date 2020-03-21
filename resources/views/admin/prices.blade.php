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
        <h4 class="page-title">Perform this activities on price module</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">View</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Add New</a></li>
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
            <button type="button" data-toggle="modal" data-target="#AddPriceModal" data-backdrop="static" class="btn btn-primary btn-round waves-effect waves-light m-1"><i class="fa fa-plus-circle"></i> ADD NEW PRICE</button>
       </div>
        <div class="card-body">
          <div class="table-responsive">
          <table id="example" class="table table-striped table-borderless">
            <thead>
                <tr>
                    <th>ID#</th>
                    <th>Service Name</th>                    
                    <th>Branch</th>
                    <th>Price <small>GH&#x20B5;</small></th>
                    @if (Auth::user()->role=='administrator' || Auth::user()->role=='developer')
                    <th>Action</th>    
                    @endif
                </tr>
            </thead>
            <tbody>
                @if (count($prices))
                @php $i=0; @endphp
                @foreach($prices as $price)
                @php $i++; @endphp
                <tr class="records">
                    <td>{{ $i }}</td>
                    <td>{{ $price->course }}</td>
                    <td>{{ $price->branch }}</td>
                    <td class="text-primary">{{ number_format($price->amount, 2) }}</td>
                    @if (Auth::user()->role=='administrator' || Auth::user()->role=='developer')
                    <td>
                        <a href="javascript:void();" title="Edit" data-toggle="tooltip" class="text-primary btn_edit" data-id="{{ $price->id }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                        <a href="javascript:void();" title="Delete" data-toggle="tooltip" data-href="{{ route('admin.price.delete', $price->id) }}" class="text-danger btn_delete"><i class="fa fa-trash"></i></a>
                    </td>
                    @endif
                </tr>
                @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th>ID#</th>
                    <th>Service Name</th>                    
                    <th>Branch</th>
                    <th>Price <small>GH&#x20B5;</small></th>
                    @if (Auth::user()->role=='administrator' || Auth::user()->role=='developer')
                    <th>Action</th>    
                    @endif
                </tr>
            </tfoot>
        </table>
        </div>
        </div>
      </div>
    </div>
  </div><!-- End Row-->


<!-- Modal -->
<div class="modal fade" id="AddPriceModal">
    <div class="modal-dialog">
        <div class="modal-content animated zoomInUp">
            <div class="modal-header">
            <h5 class="modal-title">Add New Price</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="formAddNew" method="POST" action="{{ route('admin.price.submit') }}">
                    @csrf
                    <div class="form-group validate">
                        <label for="input-3">Service</label>
                        <select name="service" class="form-control" id="basic-select service">
                            <option value="">-Select-</option>
                            @if (count($courses))
                            @foreach($courses as $course)
                            <option value="{{ $course->name }}">{{ $course->name }}</option>
                            @endforeach
                            @endif
                        </select>
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group validate">
                        <label for="input-3">Branch</label>
                        <select name="branch" class="form-control" id="basic-select branch">
                            <option value="">-Select-</option>
                            @if (count($branches))
                            @foreach($branches as $branch)
                            <option value="{{ $branch->name }}">{{ $branch->name }}</option>
                            @endforeach
                            @endif
                        </select>
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group validate">
                        <label for="input-1">Service Price</label>
                        <input type="text" name="price" id="price" class="form-control" placeholder="Enter Service Price">
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

<div class="modal fade" id="EditPriceModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated zoomInUp">
            <div class="modal-header">
            <h5 class="modal-title">Edit Price</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="formEditNew" method="POST" action="{{ route('admin.price.update') }}">
                    @csrf
                    <input type="hidden" name="price_id" id="price_id" readonly>
                    <div class="form-group validate">
                        <label for="input-1">Service Price</label>
                        <input type="text" name="price" id="price1" class="form-control" placeholder="Enter Service Price">
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    
                    <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block px-5 btn_edit_price"><i class="fa fa-refresh"></i> Update</button>
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
                title: 'SERVICE PRICES',
                exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'SERVICE PRICES',
                exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                }
            },
            {
                extend: 'print',
                title: 'SERVICE PRICES',
                exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                }
            },
            'colvis'
        ]
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

$('#price, #price1').keypress(function(event) {
    if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
            $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
}).on('paste', function(event) {
    event.preventDefault();
});


//edit
$("#example tbody").on('click', '.btn_edit', function(e){
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $("#price_id").val($this.data('id'));
    $("#price1").val($this.parents('.records').find('td').eq(3).text());
    $("#EditPriceModal").modal({backdrop: 'static'});
    return false;
});

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
        $('.btn_edit_price').html('<i class="fa fa-spinner fa-spin"></i> Updating...').attr('disabled', true);
        return true;
    }
    return false;
});

$("#formEditNew input").on('input', function(){
    if($(this).val()!=''){
        $(this).parents('.validate').find('span').text('');
    }else{ $(this).parents('.validate').find('span').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required'); }
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