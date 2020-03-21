@extends('layouts.admin')
@section('style')  
<style>
.remove-ul{
    padding: 1px; 
}
.remove-ul-li {
    float:left;
    margin: 0 10px;
    padding: 0 10px;
}
</style>
@endsection
@section('content')
<!-- Breadcrumb-->
<div class="row pt-2 pb-2">
    <div class="col-sm-9">
        <h4 class="page-title">Perform this activities on client module</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Detail</a></li>
        </ol>
    </div>
</div>
<!-- End Breadcrumb-->
 

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
            View Client Detail &nbsp;&nbsp;||&nbsp;&nbsp;
            <a href="{{ route('admin.viewstudent') }}">Go Back</a> 
       </div>
        <div class="card-body">

            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <div class="info-bordered">
                        <table class="table text-left">
                            <tr class="background-lightskyblue">
                                <td class="text-primary" colspan="2"><strong class="text-white"><i class="fa fa-lock"></i> ACCOUNT INFO</strong></td>
                            </tr> 
                            <tr>
                                <td>Date of Registration</td>
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d-M-Y') }}</td>
                            </tr>
                            <tr>
                                <td>Client ID</td>
                                <td>{{ $user->student_id }}</td>
                            </tr>
                            <tr>
                                <td>First Name</td>
                                <td>{{ $user->first_name }}</td>
                            </tr> 
                            <tr>
                                <td>Last Name</td>
                                <td>{{ $user->last_name }}</td>
                            </tr> 
                            <tr>
                                <td>Email Address</td>
                                <td title="email client"><a style="color:dodgerblue; !important" href="mailto:{{ $user->email }}"><i class="fa fa-envelope"></i> {{ $user->email }}</a></td>
                            </tr>   
                            <tr>
                                <td>Phone Number</td>
                                <td title="call client"><a style="color:dodgerblue; !important" href="tel:{{ $user->phone }}"><i class="fa fa-phone"></i> {{ $user->phone }}</a></td>
                            </tr> 
                            <tr class="background-lightskyblue">
                                <td class="text-primary" colspan="2"><strong class="text-white"><i class="fa fa-user"></i> PROFILE</strong></td>
                            </tr> 
                            <tr>
                                <td>Date of Birth</td>
                                <td>{{ $user->getDobAttribute() }} ({{ $user->getAgeAttribute() }} <small>years</small>)</td>
                            </tr>  
                            <tr>
                                <td>Place of Birth</td>
                                <td>{{ $user->profile->pob }}</td>
                            </tr>  
                            <tr>
                                <td>Passport Number</td>
                                <td>{{ $user->profile->passport }}</td>
                            </tr> 
                            <tr>
                                <td>Passport Expiry</td>
                                <td>{{ (empty($user->profile->passport_expiry))? '': \Carbon\Carbon::parse($user->profile->passport_expiry)->format('d-M-Y') }}</td>
                            </tr> 
                            <tr>
                                <td>Profession</td>
                                <td>{{ $user->profile->profession }}</td>
                            </tr> 
                            <tr>
                                <td>First Language</td>
                                <td>{{ $user->profile->language }}</td>
                            </tr> 
                            <tr>
                                <td>Preferred Country</td>
                                <td>{{ $user->profile->country }}</td>
                            </tr> 
                            <tr>
                                <td>Street Address</td>
                                <td>{{ $user->profile->street }}</td>
                            </tr>
                            <tr>
                                <td>City/Town</td>
                                <td>{{ $user->profile->city }}</td>
                            </tr>
                            <tr class="background-lightskyblue">
                                <td class="text-primary" colspan="2"><strong class="text-white"><i class="fa fa-list-ul"></i> SERVICES</strong></td>
                            </tr>  
                            <tr>
                                <td>
                                    <ul class="remove-ul">
                                        @foreach ($services as $s)
                                        <li class="remove-ul-li">{{ $s->type }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>  
                            <tr class="background-lightskyblue">
                                <td class="text-primary" colspan="2"><strong class="text-white"><i class="fa fa-user"></i> EMERGENCY</strong></td>
                            </tr>  
                            <tr>
                                <td>Name</td>
                                <td>{{ $user->emergency->name }}</td>
                            </tr>  
                            <tr>
                                <td>Phone Number</td>
                                <td>{{ $user->emergency->phone }}</td>
                            </tr> 
                            <tr>
                                <td>Address</td>
                                <td>{{ $user->emergency->address }}</td>
                            </tr> 
                        </table>
                    </div>
                </div>
            </div>

        </div>
      </div>
    </div>
  </div><!-- End Row-->

@endsection
@section('scripts')   
@endsection