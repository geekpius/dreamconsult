@extends('layouts.admin')
@section('style')  
<style class="csscreations">
    /*basic reset*/
    /* * {margin: 0; padding: 0;}

    html {height: 100%; background: #ffffff;} */

    body {font-family: montserrat, arial, verdana;}
    /*form styles*/
    #msform {
        width: 100%;
        margin: 30px auto;
        text-align: center;
        position: relative;
        margin-top: 0px;
    }
    #msform fieldset {
        background: white;
        border: 0 none;
        border-radius: 3px;
        box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
        padding: 20px 30px;
        text-align: left;
        -moz-box-sizing: border-box;
        width: 100%;

        /*stacking fieldsets above each other*/
        position: absolute;
    }
    /*Hide all except first fieldset*/
    #msform fieldset:not(:first-of-type) {display: none;}
    /*inputs*/
    #msform input, #msform button, #msform textarea {
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-bottom: 10px;
        width: 100%;
        -moz-box-sizing: border-box;
        color: #2C3E50;
        font-size: 13px;
    }
    /*buttons*/
    #msform .action-button {
        width: 100px;
        background: #27AE60;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 1px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }
    #msform .action-button:hover, #msform .action-button:focus {box-shadow: 0 0 0 2px white, 0 0 0 3px #27AE60;}

    #msform .action-button2 {
        width: 100px;
        background: #dc3545;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 1px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }
    #msform .action-button2:hover, #msform .action-button2:focus {box-shadow: 0 0 0 2px white, 0 0 0 3px #dc3545;}

    #msform #submit {
        width: 100px;
        background: #27AE60;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 1px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }
    #msform #submit:hover, #msform #submit:focus {box-shadow: 0 0 0 2px white, 0 0 0 3px #27AE60;}

    /*headings*/
    .fs-title {
        font-size: 15px;
        text-transform: uppercase;
        color: #2C3E50;
        margin-bottom: 10px;
    }
    .fs-subtitle {
        font-weight: normal;
        font-size: 13px;
        color: #666;
        margin-bottom: 20px;
    }
    /*progressbar*/
    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        /*CSS counters to number the steps*/
        counter-reset: step;
        width: 100%;
        text-align: center;
    }
    #progressbar li {
        list-style-type: none;
        color: white;
        text-transform: uppercase;
        font-size: 9px;
        width: 9.1%;
        float: left;
        position: relative;
        text-align: center;
    }
    #progressbar li:before {
        content: counter(step);
        counter-increment: step;
        width: 20px;
        line-height: 20px;
        display: block;
        font-size: 10px;
        color: #333;
        background: white;
        border-radius: 3px;
        margin: 0 auto 5px auto;
    }
    /*progressbar connectors*/
    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: white;
        position: absolute;
        left: -50%;
        top: 9px;
        z-index: -1; /*put it behind the numbers*/
    }
    #progressbar li:first-child:after {/*connector not needed before the first step*/ content: none;}
    /*marking active/completed steps green*/
    /*The number of the step and the connector before it = green*/
    #progressbar li.active:before,  #progressbar li.active:after{background: #27AE60; color: white;}

    #logo {margin: 25px auto; width: 500px;}

    #logo img {float: left;}

    .clearfix {clear: both;}

    #logo span {
        display: inline-block;
        font-size: 17px;
        vertical-align: middle;
        margin-top: 34px;
        color: #000000;
    }

    td {height: 50px; width:50px;}

    #cssTable td {text-align:center; vertical-align:middle;}

    .card-size{
        height: 600px;
    }

    @media (max-width: 450px){
        
        #msform fieldset {

            /*stacking fieldsets above each other*/
            position: relative;
        }
    }

    @media (max-width: 880px){
        .big-property-image-size{
            width: 100%;
            height: 200px !important;
            border-radius: 0.5%;
        }
        .small-property-image-size{
            width: 100%;
            height: 90px !important;
            border-radius: 0.5%;
        }
    }
    @media (max-width: 1024px){
        .big-property-image-size{
            width: 100%;
            height: 260px;
            border-radius: 0.5%;
        }
        .small-property-image-size{
            width: 100%;
            height: 120px;
            border-radius: 0.5%;
        }
    }
    @media (min-width: 2560px){
        .big-property-image-size{
            width: 100%;
            height: 700px;
            border-radius: 0.5%;
        }
        .small-property-image-size{
            width: 100%;
            height: 330px;
            border-radius: 0.5%;
        }
    }
</style>
@endsection
@section('content')
<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Perform this activities on client module</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Add New</a></li>
        </ol>
    </div>
</div>
<!-- End Breadcrumb-->
 

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
           Register New Client
       </div>
        <div class="card-body row card-size">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">

                <form id="msform" action="{{ route('admin.student.submit') }}" method="POST">
                    
                    <fieldset>
                        <h2 class="fs-title text-primary text-uppercase next"><strong>Account Info</strong></h2>
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group validate">
                                    <label>First Name<i class="text-danger">*</i></label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control" placeholder="Enter First Name">
                                    <span class="text-danger small mySpan" role="alert">{{ $errors->has('first_name') ? $errors->first('first_name') : '' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group validate">
                                    <label>Last Name<i class="text-danger">*</i></label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-control" placeholder="Enter Last Name">
                                    <span class="text-danger small mySpan" role="alert">{{ $errors->has('last_name') ? $errors->first('last_name') : '' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter Email Address">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group validate">
                                    <label>Phone Number<i class="text-danger">*</i></label>
                                    <input type="text" name="phone" id="phone" onkeypress="return isNumber(event);" value="{{ old('phone') }}" maxlength="10" class="form-control" placeholder="Enter Active Phone Number">
                                    <span class="text-danger small mySpan" role="alert">{{ $errors->has('phone') ? $errors->first('phone') : '' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" class="next action-button float-right"><i class="fa fa-arrow-right"></i> Next</button>   
                                    <button type="button" disabled class="previous action-button2" style="cursor:not-allowed"><i class="fa fa-arrow-left"></i> Previous</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                   
                    <fieldset>
                        <h2 class="fs-title text-primary text-uppercase next"><strong>PROFILE INFO</strong></h2>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" name="dob" value="{{ old('dob') }}" class="form-control" >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Place of Birth</label>
                                    <input type="text" name="pob" value="{{ old('pob') }}" class="form-control" placeholder="Enter Place of Birth">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Passport Number</label>
                                    <input type="text" name="passport_number" value="{{ old('passport_number') }}" class="form-control" placeholder="Enter Passport Number">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Passport Expiry Date</label>
                                    <input type="date" name="passport_expiry" value="{{ old('passport_expiry') }}" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Profession</label>
                                    <input type="text" name="profession" value="{{ old('profession') }}" class="form-control" placeholder="Enter Profession">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First Language</label>
                                    <input type="text" name="language" value="{{ old('language') }}" class="form-control" placeholder="Enter First Language">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Preferred Country of Migration/Study</label>
                                    <input type="text" name="country" value="{{ old('country') }}" class="form-control" placeholder="Enter Preferred Country of Migration/Study">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Street Address</label>
                                    <input type="text" name="street_address" value="{{ old('street_address') }}" class="form-control" placeholder="Enter Street Address">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" name="city" value="{{ old('city') }}" class="form-control" placeholder="Enter City">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" class="next action-button float-right"><i class="fa fa-arrow-right"></i> Next</button>   
                                    <button type="button" class="previous action-button2"><i class="fa fa-arrow-left"></i> Previous</button>
                                </div>
                            </div>
                        </div>        
                    </fieldset>

                    <fieldset>
                        <h2 class="fs-title text-primary text-uppercase next"><strong>Service Info</strong></h2>
                        <div class="row validate">
                            <div class="col-sm-12">
                                <label>Services Enquired<i class="text-danger">*</i></label>
                            </div>
                            @if (count($services))
                            @php $i=0; @endphp
                            @foreach($services as $service)
                            @php $i++; @endphp
                            <div class="col-sm-3">
                                <div class="form-group py-2">
                                    <div class="icheck-material-primary">
                                        <input type="checkbox" name="services[]" id="{{ $i }}" value="{{ $service->name }}">
                                        <label for="{{ $i }}">{{ $service->name }}</label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif    
                            <span class="text-danger small" role="alert">{{ $errors->has('services') ? $errors->first('services') : '' }}</span>
                        </div>
                        @if (Auth::user()->branch=='HEAD OFFICE')
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group validate">
                                    <label>Branch<i class="text-danger">*</i></label>
                                    <select name="branch" class="form-control" id="branch">
                                        <option value="">-Select-</option>
                                        @if (count($branches))
                                            @foreach($branches as $h)
                                            <option value="{{$h->name}}">{{$h->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="text-danger small mySpan" role="alert">{{ $errors->has('branch') ? $errors->first('branch') : '' }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group validate">
                                    <label>Registration<i class="text-danger">*</i></label>
                                    <input type="date" name="registration" id="registration" value="{{ old('registration') }}" class="form-control" >
                                    <span class="text-danger small mySpan" role="alert">{{ $errors->has('registration') ? $errors->first('registration') : '' }}</span>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group validate">
                                    <label>Registration<i class="text-danger">*</i></label>
                                    <input type="date" name="registration" id="registration" value="{{ old('registration') }}" class="form-control" >
                                    <span class="text-danger small mySpan" role="alert">{{ $errors->has('registration') ? $errors->first('registration') : '' }}</span>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group validate">
                                    <label>Discount Service</label>
                                    <select name="discount_service" class="form-control" id="discount_service">
                                        <option value="">-Select-</option>
                                        @if (count($services))
                                            @foreach($services as $service)
                                            <option value="{{$service->name}}">{{$service->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group validate">
                                    <label>Discount</label>
                                    <input type="text" name="discount" id="discount" onkeypress="return isNumber(event);" value="{{ old('discount') }}" class="form-control" >
                                    <span class="text-danger small mySpan" role="alert">{{ $errors->has('discount') ? $errors->first('discount') : '' }}</span>
                                </div>
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" class="next action-button float-right"><i class="fa fa-arrow-right"></i> Next</button>   
                                    <button type="button" class="previous action-button2"><i class="fa fa-arrow-left"></i> Previous</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <h2 class="fs-title text-primary text-uppercase next"><strong>Emergency Info</strong></h2>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Emergency Contact Person</label>
                                    <input type="text" name="emergency" value="{{ old('emergency') }}" class="form-control" placeholder="Enter Emergency Contact Person">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Emergency Phone</label>
                                    <input type="text" name="emergency_phone" onkeypress="return isNumber(event);" maxlength="10" value="{{ old('emergency_phone') }}" class="form-control" placeholder="Enter Emergency Phone Number">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Emergency Address</label>
                                    <input type="text" name="emergency_address" value="{{ old('emergency_address') }}" class="form-control" placeholder="Enter Emergency Address">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="button" class="next action-button float-right"><i class="fa fa-arrow-right"></i> Finish</button>   
                                    <button type="button" class="previous action-button2"><i class="fa fa-arrow-left"></i> Previous</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                </form>

            </div>            
        </div>
      </div>
    </div>
  </div><!-- End Row-->

@endsection
@section('scripts')   
<script src="{{ asset('assets/js/jquery.easing.min.js') }}"></script>
<script>
$("#branch").val("{{ old('branch') }}");

$("#msform select").on('change', function(){
    if($(this).val()!=''){
        $(this).parents('.validate').find('.mySpan').text('');
    }else{ 
        $(this).parents('.validate').find('.mySpan').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required');
    }
});

$("#msform input").on('input', function(){
    if($(this).val()!=''){
        $(this).parents('.validate').find('.mySpan').text('');
    }else{ 
        $(this).parents('.validate').find('.mySpan').text('The '+$(this).attr('name').replace(/[\_]+/g, ' ')+' field is required');
    }
});

$('#discount').keypress(function(event) {
    if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
            $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
}).on('paste', function(event) {
    event.preventDefault();
});


//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
    var $this = $(this);
    var valid = true;
    var counterCheck = $(this).parent().parent().parent().parent().nextAll().length;
    if(counterCheck==3){
        $('#msform #first_name, #msform #last_name, #msform #phone').each(function() {
            var $this = $(this);
            
            if(!$this.val()) {
                valid = false;
                $this.parents('.validate').find('.mySpan').text('The '+$this.attr('name').replace(/[\_]+/g, ' ')+' field is required');
            }
        });
    }
    else if(counterCheck==1){
        $('#msform #branch, #msform #registration').each(function() {
            var $this = $(this);
            
            if(!$this.val()) {
                valid = false;
                $this.parents('.validate').find('.mySpan').text('The '+$this.attr('name').replace(/[\_]+/g, ' ')+' field is required');
            }
        });
    }
    
    if(valid){
        if(animating) return false;
        animating = true;
        current_fs = $(this).parent().parent().parent().parent();
        next_fs = $(this).parent().parent().parent().parent().next();
        //activate next step on progressbar using the index of next_fs
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                //2. bring next_fs from the right(50%)
                left = (now * 50)+"%";
                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({'transform': 'scale('+scale+')'});
                next_fs.css({'left': left, 'opacity': opacity});
            },
            duration: 800,
            complete: function(){
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
        
        //check for the last one and submit
        var counterCheck = $(this).parent().parent().parent().parent().nextAll().length;
        if(counterCheck==0){
            document.getElementById("msform").submit();
        } 
    }
    
    //console.log(counterCheck)
});


$(".previous").click(function(){
    if(animating) return false;
    animating = true;
    current_fs = $(this).parent().parent().parent().parent()
    previous_fs = $(this).parent().parent().parent().parent().prev();
    //de-activate current step on progressbar
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
    //show the previous fieldset
    previous_fs.show();
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
        step: function(now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale previous_fs from 80% to 100%
            scale = 0.8 + (1 - now) * 0.2;
            //2. take current_fs to the right(50%) - from 0%
            left = ((1-now) * 50)+"%";
            //3. increase opacity of previous_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({'left': left});
            previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
        },
        duration: 800,
        complete: function(){
            current_fs.hide();
            animating = false;
        },
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });
});


/* function f1(objButton){
    document.getElementById(objButton.name).value =objButton.id;
} */


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

</script>  
@endsection