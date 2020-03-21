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
        <h4 class="page-title">Perform this activities on service transaction module</h4>
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
            <button type="button" class="btn btn-primary px-4 mr-5 btn-sm btn_reload"><i class="fa fa-refresh"></i> RELOAD ALL</button>
            <button type="button" class="btn btn-primary px-4 mr-1 btn-sm btn_today"><i class="fa fa-calendar-o"></i> TODAY</button>
            <button type="button" class="btn btn-primary px-4 mr-1 btn-sm btn_week"><i class="fa fa-calendar-o"></i> THIS WEEK</button>
            <button type="button" class="btn btn-primary px-4 btn-sm btn_month"><i class="fa fa-calendar-o"></i> THIS MONTH</button>
            <button type="button" class="btn btn-primary px-4 ml-1 btn-sm btn_year"><i class="fa fa-calendar-o"></i> THIS YEAR</button>
            <button type="button" data-toggle="modal" data-target="#SingleModal" data-backdrop="static" class="btn btn-primary px-4 btn-sm ml-1 btn_single"><i class="fa fa-calendar-o"></i> SINGLE DATE</button>
            <button type="button" data-toggle="modal" data-target="#RangeModal" data-backdrop="static" class="btn btn-primary px-4 btn-sm ml-1 btn_range"><i class="fa fa-calendar-o"></i> RANGE DATE</button>
       </div>
        <div class="card-body">
            <div class="table-responsive" id="table_content">
                
            </div>
        </div>
      </div>
    </div>
  </div><!-- End Row-->


<!-- Modal -->
<div class="modal fade" id="SingleModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated zoomInUp">
            <div class="modal-header">
            <h5 class="modal-title">Filter Single Dates</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="formSingle">
                    <div class="form-group validate">
                        <label>Select Date</label>
                        <input type="date" name="date" class="form-control input-sm">
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block px-5 btn_filter1"><i class="fa fa-search"></i> Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="RangeModal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated zoomInUp">
            <div class="modal-header">
            <h5 class="modal-title">Filter Between Dates</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="formRange">
                    <div class="form-group validate">
                        <label for="input-1">First Date</label>
                        <input type="date" name="first_date" class="form-control input-sm">
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group validate">
                        <label for="input-1">End Date</label>
                        <input type="date" name="end_date" class="form-control input-sm">
                        <span class="text-danger small" role="alert"></span>
                    </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-success btn-block px-5 btn_filter"><i class="fa fa-search"></i> Filter</button>
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
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
})

function getAllTableContent(){
    $("#table_content").html('<div class="text-center"><i class="fa fa-spin fa-spinner text-primary fa-5x"></i></div>');
    $.ajax({
        url: "{{ route('admin.service.transactions.all') }}",
        type: "GET",
        success: function(resp){
            $("#table_content").html(resp);
        },
        error: function(resp){
            alert('Something went wrong');
        }
    });
}

function getTodayTableContent(){
    $("#table_content").html('<div class="text-center"><i class="fa fa-spin fa-spinner text-primary fa-5x"></i></div>');
    $.ajax({
        url: "{{ route('admin.service.transactions.today') }}",
        type: "GET",
        success: function(resp){
            $("#table_content").html(resp);
        },
        error: function(resp){
            alert('Something went wrong');
        }
    });
}

function getWeekTableContent(){
    $("#table_content").html('<div class="text-center"><i class="fa fa-spin fa-spinner text-primary fa-5x"></i></div>');
    $.ajax({
        url: "{{ route('admin.service.transactions.week') }}",
        type: "GET",
        success: function(resp){
            $("#table_content").html(resp);
        },
        error: function(resp){
            alert('Something went wrong');
        }
    });
}

function getSingleTableContent(data){
    $("#table_content").html('<div class="text-center"><i class="fa fa-spin fa-spinner text-primary fa-5x"></i></div>');
    $.ajax({
        url: "{{ route('admin.service.transactions.single') }}",
        type: "POST",
        data: data,
        success: function(resp){
            $("#table_content").html(resp);
            $("#SingleModal").modal('hide');
            $('.btn_filter1').html('<i class="fa fa-search"></i> Filter').attr('disabled', false);
            document.getElementById("formSingle").reset();
        },
        error: function(resp){
            alert('Something went wrong');
        }
    });
}

function getRangeTableContent(data){
    $("#table_content").html('<div class="text-center"><i class="fa fa-spin fa-spinner text-primary fa-5x"></i></div>');
    $.ajax({
        url: "{{ route('admin.service.transactions.range') }}",
        type: "POST",
        data: data,
        success: function(resp){
            $("#table_content").html(resp);
            $("#RangeModal").modal('hide');
            $('.btn_filter').html('<i class="fa fa-search"></i> Filter').attr('disabled', false);
            document.getElementById("formRange").reset();
        },
        error: function(resp){
            alert('Something went wrong');
        }
    });
}

function getMonthTableContent(){
    $("#table_content").html('<div class="text-center"><i class="fa fa-spin fa-spinner text-primary fa-5x"></i></div>');
    $.ajax({
        url: "{{ route('admin.service.transactions.month') }}",
        type: "GET",
        success: function(resp){
            $("#table_content").html(resp);
        },
        error: function(resp){
            alert('Something went wrong');
        }
    });
}

function getYearTableContent(){
    $("#table_content").html('<div class="text-center"><i class="fa fa-spin fa-spinner text-primary fa-5x"></i></div>');
    $.ajax({
        url: "{{ route('admin.service.transactions.year') }}",
        type: "GET",
        success: function(resp){
            $("#table_content").html(resp);
        },
        error: function(resp){
            alert('Something went wrong');
        }
    });
}
 
getAllTableContent();

$(".btn_reload").on('click', function(){
    getAllTableContent();
    return false;
});

$(".btn_today").on('click', function(){
    getTodayTableContent();
    return false;
});

$(".btn_week").on('click', function(){
    getWeekTableContent();
    return false;
});

$(".btn_month").on('click', function(){
    getMonthTableContent();
    return false;
});

$(".btn_year").on('click', function(){
    getYearTableContent();
    return false;
});

$("#formRange").on("submit", function(e){
    e.stopPropagation();
    var valid = true;
    $('#formRange input').each(function() {
        var $this = $(this);
        
        if(!$this.val()) {
            valid = false;
            $this.parents('.validate').find('span').text('The '+$this.attr('name').replace(/[\_]+/g, ' ')+' field is required');
        }
    });
    if(valid) {
        $('.btn_filter').html('<i class="fa fa-spinner fa-spin"></i> Filtering...').attr('disabled', true);
        var data= $("#formRange").serialize();
        getRangeTableContent(data);
    }
    return false;
});

$("#formSingle").on("submit", function(e){
    e.stopPropagation();
    var valid = true;
    $('#formSingle input').each(function() {
        var $this = $(this);
        
        if(!$this.val()) {
            valid = false;
            $this.parents('.validate').find('span').text('The '+$this.attr('name').replace(/[\_]+/g, ' ')+' field is required');
        }
    });
    if(valid) {
        $('.btn_filter1').html('<i class="fa fa-spinner fa-spin"></i> Filtering...').attr('disabled', true);
        var data= $("#formSingle").serialize();
        getSingleTableContent(data);
    }
    return false;
});

$("#formRange input, #formSingle input").on('input', function(){
    if($(this).val()!=''){
        $(this).parents('.validate').find('span').text('');
    }else{ $(this).parents('.validate').find('span').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required'); }
}); 

</script>  
@endsection