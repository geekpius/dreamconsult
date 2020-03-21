@if(session()->has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <div class="alert-icon contrast-alert">
        <i class="fa fa-check"></i>
    </div>
    <div class="alert-message">
        <span><strong>Success!</strong> {{ session()->get('success') }}</span>
    </div>
</div>
@elseif(session()->has('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <div class="alert-icon contrast-alert">
        <i class="fa fa-times"></i>
    </div>
    <div class="alert-message">
        <span><strong>Opps:</strong> {{ session()->get('error') }} </span>
    </div>
</div>  
@elseif(session('status'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <div class="alert-icon contrast-alert">
        <i class="fa fa-times"></i>
    </div>
    <div class="alert-message">
        <span><strong>Success!</strong> {{ session('status') }} </span>
    </div>
</div> 
@endif
