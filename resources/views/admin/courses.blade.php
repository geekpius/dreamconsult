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
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">View</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Add New</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Delete</a></li>
        </ol>
    </div>
</div>
<!-- End Breadcrumb-->
 

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
            <button type="button" data-toggle="modal" data-target="#AddCourseModal" data-backdrop="static" class="btn btn-primary btn-round waves-effect waves-light m-1"><i class="fa fa-plus-circle"></i> ADD NEW SERVICE</button>
       </div>
        <div class="card-body">
          <div class="table-responsive">
          <table id="example" class="table table-striped table-borderless">
            <thead>
                <tr>
                    <th>ID#</th>
                    <th>Service Name</th>
                    <th>Service Color</th>
                    <th>Status</th>
                    @if (Auth::user()->role=='administrator' || Auth::user()->role=='developer')
                    <th>Action</th>    
                    @endif
                </tr>
            </thead>
            <tbody>
                @if (count($courses))
                @php $i=0; @endphp
                @foreach($courses as $course)
                @php $i++; @endphp
                <tr class="records">
                    <td>{{ $i }}</td>
                    <td>{{ $course->name }}</td>
                    <td><i class="fa fa-circle mr-2" style="color: {{ $course->color }}"></i></td>
                    <td>{{ $course->status? 'IN':'OUT' }}</td>
                    @if (Auth::user()->role=='administrator' || Auth::user()->role=='developer')
                    <td>
                        <a href="javascript:void();" data-id="{{ $course->id }}" title="Edit" data-toggle="tooltip" class="text-primary btnEdit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="javascript:void();" title="Delete" data-toggle="tooltip" data-href="{{ route('admin.course.delete', $course->id) }}" class="text-danger btn_delete"><i class="fa fa-trash"></i></a>
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
                    <th>Service Color</th>
                    <th>Status</th>
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
<div class="modal fade" id="AddCourseModal">
    <div class="modal-dialog">
        <div class="modal-content animated zoomInUp">
            <div class="modal-header">
            <h5 class="modal-title">Add New Service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="formAddNew" method="POST" action="{{ route('admin.course.submit') }}">
                    @csrf
                    <div class="form-group validate">
                        <label for="input-1">Service Name</label>
                        <input type="text" name="service" class="form-control" placeholder="Enter Service Name">
                        <span class="text-danger small" role="alert"></span>
                    </div>

                    <div class="form-group validate">
                        <label for="input-3">Service Color</label>
                        <select name="service_color" class="form-control" id="service_color">
                            <option value="">-Select-</option>
                            <option value="#7934f3">Primary</option>
                            <option value="#94614f">Secondary</option>
                            <option value="#04b962">Success</option>
                            <option value="#14b6ff">Info</option>
                            <option value="#f43643">Danger</option>
                            <option value="#0a151f">Dark</option>
                            <option value="#ff8800">Warning</option>
                            <option value="#FF5733">Color1</option>
                            <option value="#0B5345">Color2</option>
                            <option value="#4A235A">Color3</option>
                            <option value="#F1C40F">Color4</option>
                        </select>
                        <span class="text-danger small" role="alert"></span>
                    </div>

                    <div class="form-group validate">
                        <label for="input-3">Status</label>
                        <select name="status" class="form-control" id="status">
                            <option value="">-Select-</option>
                            <option value="1">IN</option>
                            <option value="0">OUT</option>
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

<div class="modal fade" id="EditServiceModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated zoomInUp">
            <div class="modal-header">
            <h5 class="modal-title">Edit Service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="formEditNew" method="POST" action="{{ route('admin.course.edit') }}">
                    @csrf
                    <input type="hidden" name="service_id" id="service_id" readonly>
                    <div class="form-group validate">
                        <label for="input-1">Service Name</label>
                        <input type="text" name="service" id="service_name" class="form-control" placeholder="Enter Service Name">
                        <span class="text-danger small" role="alert"></span>
                    </div>

                    <div class="form-group validate">
                        <label for="input-3">Status</label>
                        <select name="status" class="form-control" id="status1">
                            <option value="1">IN</option>
                            <option value="0">OUT</option>
                        </select>
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
                title: 'SERVICES',
                exportOptions: {
                    columns: [ 0, 1 ]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0, 1 ]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'SERVICES',
                exportOptions: {
                    columns: [ 0, 1 ]
                }
            },
            {
                extend: 'print',
                title: 'SERVICES',
                exportOptions: {
                    columns: [ 0, 1 ]
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
    }else{ $(this).parents('.validate').find('span').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required'); }
});


//edit
$("#example tbody").on('click', '.btnEdit', function(e){
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this);
    $("#service_id").val($this.data('id'));
    $("#formEditNew #service_name").val($this.parents('.records').find('td').eq(1).text());
    $("#formEditNew #status1").val(($this.parents('.records').find('td').eq(3).text()=='IN')? 1:0);
    $("#EditServiceModal").modal({backdrop: 'static'});
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
        $('.btn_edit_price').html('<i class="fa fa-spinner fa-spin"></i> Updating...').attr('disabled', true);
        return true;
    }
    return false;
});

$("#formEditNew input, #formEditNew select").on('input', function(){
    if($(this).val()!=''){
        $(this).parents('.validate').find('span').text('');
    }else{ $(this).parents('.validate').find('span').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required'); }
});


//delete
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