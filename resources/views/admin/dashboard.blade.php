@extends('layouts.admin')

@section('style')
@endsection
@section('content')
<div class="animated bounceInDown">
<div class="row mt-3">
  <div class="col-12 col-lg-6 col-xl-3">
      <a href="{{ route('admin.viewstudent.incomplete') }}">
        <div class="card gradient-deepblue">
          <div class="card-body">
            <h5 class="text-white mb-0">{{ $count_new_visitors+$count_visitors }} <span class="float-right"><i class="fa fa-user"></i></span></h5>
              <div class="progress my-3" style="height:3px;">
                 <div class="progress-bar" style="width:55%"></div>
              </div>
            <p class="mb-0 text-white small-font">Total Visitors <span class="float-right">+4.2% <i class="zmdi zmdi-long-arrow-up"></i></span></p>
          </div>
        </div> 
      </a>
  </div>
  <div class="col-12 col-lg-6 col-xl-3">
      <a href="{{ route('admin.viewstudent') }}">
        <div class="card gradient-orange">
          <div class="card-body">
            <h5 class="text-white mb-0">{{ $count_clients }} <span class="float-right"><i class="fa fa-user-circle-o"></i></span></h5>
              <div class="progress my-3" style="height:3px;">
                 <div class="progress-bar" style="width:55%"></div>
              </div>
            <p class="mb-0 text-white small-font">Total Clients <span class="float-right">+1.2% <i class="zmdi zmdi-long-arrow-up"></i></span></p>
          </div>
        </div>
      </a>
  </div>
  <div class="col-12 col-lg-6 col-xl-3">
      <a href="{{ route('admin.makepayment') }}">
        <div class="card gradient-ohhappiness">
          <div class="card-body">
            <h5 class="text-white mb-0">{{ $count_debtors }} <span class="float-right"><i class="fa fa-address-card"></i></span></h5>
              <div class="progress my-3" style="height:3px;">
                 <div class="progress-bar" style="width:55%"></div>
              </div>
            <p class="mb-0 text-white small-font">Total Debtors <span class="float-right">+5.2% <i class="zmdi zmdi-long-arrow-up"></i></span></p>
          </div>
        </div>
      </a>
  </div>
  <div class="col-12 col-lg-6 col-xl-3">
    <a href="{{ route('admin.fullpayers') }}">
      <div class="card gradient-ibiza">
        <div class="card-body">
          <h5 class="text-white mb-0">{{ $count_payers }} <span class="float-right"><i class="fa fa-address-card"></i></span></h5>
            <div class="progress my-3" style="height:3px;">
               <div class="progress-bar" style="width:55%"></div>
            </div>
          <p class="mb-0 text-white small-font">Total (Full Payers) <span class="float-right">+2.2% <i class="zmdi zmdi-long-arrow-up"></i></span></p>
        </div>
      </div>
    </a>
  </div>
</div><!--End Row-->

<div class="row">
  @if (Auth::user()->role=='accountant' || Auth::user()->role=='administrator' || Auth::user()->role=='developer')
  {{-- Services transactions --}}
  <div class="col-12 col-lg-4 col-xl-4">
    <div class="card">
      <div class="card-header">Daily Transactions - {{ \Carbon\Carbon::today()->format('d-M-Y') }}
        <div class="card-action">
        <div class="dropdown">
        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
          <i class="icon-options"></i>
        </a>
        </div>
        </div>  
      </div>
      <div class="card-body">
          <div class="chart-container-2">
            <canvas id="chart5"></canvas>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <tbody>
            @if (count($services))
            @foreach($services as $service)   
            @php $daily = App\AdminModel\Payment::whereService($service->name)->whereDate('created_at','=',\Carbon\Carbon::today())->sum('paid'); @endphp
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: {{ $service->color }}"></i> {{ $service->name }}</td>
              <td><small>GH&#x20B5;</small> {{ number_format($daily,2) }} </td>
              <td>{{ ($tdaily!=0)? round(($daily/$tdaily)*100,2):0 }}%</td>
            </tr>
            @endforeach
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: #F01111"></i>TOTAL</td>
              <td><small>GH&#x20B5;</small> {{ number_format($tdaily,2) }} </td>
              <td>100% </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-4 col-xl-4">
    <div class="card">
      <div class="card-header">Weekly Transactions - From {{ \Carbon\Carbon::now()->startOfWeek()->format('d-M-Y') }} to {{ \Carbon\Carbon::now()->endOfWeek()->format('d-M-Y') }}
        <div class="card-action">
        <div class="dropdown">
        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
          <i class="icon-options"></i>
        </a>
        </div>
        </div>  
      </div>
      <div class="card-body">
          <div class="chart-container-2">
            <canvas id="chart6"></canvas>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <tbody>
            @if (count($services))
            @foreach($services as $service)   
            @php $weekly = \App\AdminModel\Payment::whereService($service->name)->whereDate('created_at','>=',\Carbon\Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at','<=',\Carbon\Carbon::now()->endOfWeek()->format('Y-m-d'))->sum('paid'); @endphp
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: {{ $service->color }}"></i> {{ $service->name }}</td>
              <td><small>GH&#x20B5;</small> {{ number_format($weekly,2) }} </td>
              <td>{{ ($tweekly!=0)? round(($weekly/$tweekly)*100,2):0 }}%</td>
            </tr>
            @endforeach
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: #F01111"></i>TOTAL</td>
              <td><small>GH&#x20B5;</small> {{ number_format(($tweekly),2) }} </td>
              <td>100% </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-4 col-xl-4">
    <div class="card">
      <div class="card-header">Monthly Transactions - {{ \Carbon\Carbon::now()->format('F') }}
        <div class="card-action">
        <div class="dropdown">
        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
          <i class="icon-options"></i>
        </a>
        </div>
        </div>  
      </div>
      <div class="card-body">
          <div class="chart-container-2">
            <canvas id="chart7"></canvas>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <tbody>
            @if (count($services))
            @foreach($services as $service)   
            @php $monthly = \App\AdminModel\Payment::whereService($service->name)->whereMonth('created_at','>=', \Carbon\Carbon::now()->month)->sum('paid'); @endphp
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: {{ $service->color }}"></i> {{ $service->name }}</td>
              <td><small>GH&#x20B5;</small> {{ number_format($monthly,2) }} </td>
              <td>{{ ($tmonthly!=0)? round(($monthly/$tmonthly)*100,2):0 }}%</td>
            </tr>
            @endforeach
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: #F01111"></i>TOTAL</td>
              <td><small>GH&#x20B5;</small> {{ number_format($tmonthly,2) }} </td>
              <td>100% </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- money in and out --}}
  <div class="col-12 col-lg-4 col-xl-4">
    <div class="card">
      <div class="card-header">Daily Cash Flow - {{ \Carbon\Carbon::today()->format('d-M-Y') }}
        <div class="card-action">
        <div class="dropdown">
        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
          <i class="icon-options"></i>
        </a>
        </div>
        </div>  
      </div>
      <div class="card-body">
          <div class="chart-container-2">
            <canvas id="chart8"></canvas>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <tbody>
            @php $sumDailyIn=0; $sumDailyOut=0; @endphp
            @foreach ($inservices as $is)
            @php 
              $daily = App\AdminModel\Payment::whereService($is->name)->whereDate('created_at','=',\Carbon\Carbon::today())->sum('paid'); 
              $sumDailyIn += $daily;
            @endphp
            @endforeach

            @foreach ($outservices as $os)
            @php 
              $daily = App\AdminModel\Payment::whereService($os->name)->whereDate('created_at','=',\Carbon\Carbon::today())->sum('paid'); 
              $sumDailyOut += $daily;
            @endphp
            @endforeach
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: #04b962"></i>IN</td>
              <td><small>GH&#x20B5;</small> {{ number_format($sumDailyIn,2) }} </td>
              <td>{{ $tdaily!=0? round(($sumDailyIn/($sumDailyIn+$sumDailyOut))*100,2):0 }}% </td>
            </tr>
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: #7934f3"></i>OUT</td>
              <td><small>GH&#x20B5;</small> {{ number_format($sumDailyOut,2) }} </td>
              <td>{{ $tdaily!=0? round(($sumDailyOut/($sumDailyIn+$sumDailyOut))*100,2):0 }}% </td>
            </tr>
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: #F01111"></i>TOTAL</td>
              <td><small>GH&#x20B5;</small> {{ number_format(($sumDailyIn+$sumDailyOut),2) }} </td>
              <td>100% </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-4 col-xl-4">
    <div class="card">
      <div class="card-header">Weekly Cash Flow - From {{ \Carbon\Carbon::now()->startOfWeek()->format('d-M-Y') }} to {{ \Carbon\Carbon::now()->endOfWeek()->format('d-M-Y') }}
        <div class="card-action">
        <div class="dropdown">
        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
          <i class="icon-options"></i>
        </a>
        </div>
        </div>  
      </div>
      <div class="card-body">
          <div class="chart-container-2">
            <canvas id="chart9"></canvas>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <tbody>
            @php $sumWeekIn=0; $sumWeekOut=0; @endphp
            @foreach ($inservices as $is)
            @php 
              $weekly = \App\AdminModel\Payment::whereService($is->name)->whereDate('created_at','>=',\Carbon\Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at','<=',\Carbon\Carbon::now()->endOfWeek()->format('Y-m-d'))->sum('paid');
              $sumWeekIn += $weekly;
            @endphp
            @endforeach

            @foreach ($outservices as $os)
            @php 
              $weekly = \App\AdminModel\Payment::whereService($os->name)->whereDate('created_at','>=',\Carbon\Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at','<=',\Carbon\Carbon::now()->endOfWeek()->format('Y-m-d'))->sum('paid');
              $sumWeekOut += $weekly;
            @endphp
            @endforeach
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: #04b962"></i>IN</td>
              <td><small>GH&#x20B5;</small> {{ number_format($sumWeekIn,2) }} </td>
              <td>{{ $tweekly!=0? round(($sumWeekIn/($sumWeekIn+$sumWeekOut))*100,2):0 }}% </td>
            </tr>
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: #7934f3"></i>OUT</td>
              <td><small>GH&#x20B5;</small> {{ number_format($sumWeekOut,2) }} </td>
              <td>{{ $tweekly!=0? round(($sumWeekOut/($sumWeekIn+$sumWeekOut))*100,2):0 }}% </td>
            </tr>
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: #F01111"></i>TOTAL</td>
              <td><small>GH&#x20B5;</small> {{ number_format(($sumWeekIn+$sumWeekOut),2) }} </td>
              <td>100% </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-4 col-xl-4">
    <div class="card">
      <div class="card-header">Monthly Cash Flow - {{ \Carbon\Carbon::now()->format('F') }}
        <div class="card-action">
        <div class="dropdown">
        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
          <i class="icon-options"></i>
        </a>
        </div>
        </div>  
      </div>
      <div class="card-body">
          <div class="chart-container-2">
            <canvas id="chart10"></canvas>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <tbody>
            <table class="table align-items-center">
              <tbody>
                @php $sumMonthIn=0; $sumMonthOut=0; @endphp
                @foreach ($inservices as $is)
                @php 
                  $monthly = \App\AdminModel\Payment::whereService($is->name)->whereMonth('created_at','>=', \Carbon\Carbon::now()->month)->sum('paid');
                  $sumMonthIn += $monthly;
                @endphp
                @endforeach
    
                @foreach ($outservices as $os)
                @php 
                  $monthly = \App\AdminModel\Payment::whereService($os->name)->whereMonth('created_at','>=', \Carbon\Carbon::now()->month)->sum('paid');
                  $sumMonthOut += $monthly;
                @endphp
                @endforeach
                <tr>
                  <td><i class="fa fa-circle mr-2" style="color: #04b962"></i>IN</td>
                  <td><small>GH&#x20B5;</small> {{ number_format($sumMonthIn,2) }} </td>
                  <td>{{ $monthly!=0? round(($sumMonthIn/($sumMonthIn+$sumMonthOut))*100,2):0 }}% </td>
                </tr>
                <tr>
                  <td><i class="fa fa-circle mr-2" style="color: #7934f3"></i>OUT</td>
                  <td><small>GH&#x20B5;</small> {{ number_format($sumMonthOut,2) }} </td>
                  <td>{{ $monthly!=0? round(($sumMonthOut/($sumMonthIn+$sumMonthOut))*100,2):0 }}% </td>
                </tr>
                <tr>
                  <td><i class="fa fa-circle mr-2" style="color: #F01111"></i>TOTAL</td>
                  <td><small>GH&#x20B5;</small> {{ number_format(($sumMonthIn+$sumMonthOut),2) }} </td>
                  <td>100% </td>
                </tr>
              </tbody>
            </table>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Branches --}}
  <div class="col-12 col-lg-4 col-xl-4">
    <div class="card">
      <div class="card-header">Branches Clients
        <div class="card-action">
        <div class="dropdown">
        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
          <i class="icon-options"></i>
        </a>
        </div>
        </div>  
      </div>
      <div class="card-body">
          <div class="chart-container-2">
            <canvas id="chart2"></canvas>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <tbody>
          @if (count($branches))
          @foreach($branches as $branch)   
          @php $clients = App\User::whereBranch($branch->name)->count(); @endphp
          <tr>
            <td><i class="fa fa-circle mr-2" style="color: {{ $branch->branch_color }}"></i> {{ $branch->name }}</td>
            <td>{{ $clients }} </td>
            <td>{{ ($count_clients!=0)? round(($clients/$count_clients)*100,2):0 }}%</td>
          </tr>         
          @endforeach
          <tr>
            <td><i class="fa fa-circle mr-2" style="color:red"></i>TOTAL</td>
            <td>{{ $count_clients }} </td>
            <td>100% </td>
          </tr>
          @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-4 col-xl-4">
    <div class="card">
      <div class="card-header">Branches Debts
        <div class="card-action">
        <div class="dropdown">
        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
          <i class="icon-options"></i>
        </a>
        </div>
        </div>  
      </div>
      <div class="card-body">
          <div class="chart-container-2">
            <canvas id="chart3"></canvas>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <tbody>
          @if (count($branches))
          @foreach($branches as $branch)   
          @php $debts = App\User::whereBranch($branch->name)->sum("balance"); @endphp
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: {{ $branch->branch_color }}"></i> {{ $branch->name }}</td>
              <td><small>GH&#x20B5;</small> {{ number_format($debts,2) }} </td>
              <td>{{ ($total_debts!=0)? round(($debts/$total_debts)*100,2):0 }}%</td>
            </tr>
          @endforeach
          <tr>
            <td><i class="fa fa-circle mr-2" style="color: #F01111"></i>TOTAL</td>
            <td><small>GH&#x20B5;</small> {{ number_format(($total_debts),2) }} </td>
            <td> 100% </td>
          </tr>
          @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-4 col-xl-4">
    <div class="card">
      <div class="card-header">Branches Payments
        <div class="card-action">
        <div class="dropdown">
        <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
          <i class="icon-options"></i>
        </a>
        </div>
        </div>  
      </div>
      <div class="card-body">
          <div class="chart-container-2">
            <canvas id="chart4"></canvas>
          </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <tbody>
            @if (count($branches))
            @foreach($branches as $branch)   
            @php $pays = App\User::whereBranch($branch->name)->sum("paid"); @endphp
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: {{ $branch->branch_color }}"></i> {{ $branch->name }}</td>
              <td><small>GH&#x20B5;</small> {{ number_format($pays,2) }} </td>
              <td>{{ (($total_pays)!=0)? round(($pays/($total_pays))*100,2):0 }}%</td>
            </tr>
            @endforeach
            <tr>
              <td><i class="fa fa-circle mr-2" style="color: #F01111"></i>TOTAL</td>
              <td><small>GH&#x20B5;</small> {{ number_format(($total_pays),2) }} </td>
              <td>100% </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>   
  @endif
</div><!--End Row-->

@if (Auth::user()->role=='front desk')
<div class="row">
  <div class="col-12 col-sm-6">
      <div class="card">
        <div class="card-header">Daily Statistics - {{ \Carbon\Carbon::now()->format('D d F, Y') }}
          <div class="card-action">
          <div class="dropdown">
            <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
              <i class="icon-options"></i>
            </a>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table align-items-center">
            <tbody>
              <tr class="text-primary">
                <td><i class="fa fa-circle mr-2"></i> Data</td>
                <td>No#</td>
                <td>Percentage(%)</td>
              </tr>
              <tr>
                <td><i class="fa fa-circle mr-2" style="color: #14abef"></i> Visitors</td>
                <td>{{ $today_visitors }}</td>
                <td>{{ ($count_visitors!=0)? round(($today_visitors/$count_visitors)*100,2):0 }}%</td>
              </tr>
              <tr>
                <td><i class="fa fa-circle mr-2" style="color: #02ba5a"></i>Clients</td>
                <td>{{ $today_clients }}</td>
                <td>{{ ($count_clients!=0)? round(($today_clients/$count_clients)*100,2):0 }}%</td>
              </tr>
              <tr>
                <td><i class="fa fa-circle mr-2" style="color: red"></i>Total</td>
                <td>{{ $today_clients + $today_visitors }}</td>
                @php
                    $vp = ($count_visitors!=0)? round(($today_visitors/$count_visitors)*100,2):0;
                    $cp = ($count_clients!=0)? round(($today_clients/$count_clients)*100,2):0;
                @endphp
                <td>{{ 100-($vp+$cp) }}%</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
  </div>
  <div class="col-12 col-sm-6">
    <div class="card">
      <div class="card-header">Daily Percentage Statistics - {{ \Carbon\Carbon::now()->format('D d F, Y') }}
        <div class="card-action">
        <div class="dropdown">
          <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
            <i class="icon-options"></i>
          </a>
          </div>
        </div>
      </div>
      <div class="chart-container-2">
        <canvas id="chart11"></canvas>
      </div>
    </div>
  </div>
</div><!--End Row-->    
@endif

</div>
@endsection
@section('scripts')   
<!-- Chart js -->
<script src="{{ asset('assets/plugins/Chart.js/Chart.min.js') }}"></script>
<!-- Vector map JavaScript -->
<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- Easy Pie Chart JS -->
<script src="{{ asset('assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
<!-- Sparkline JS -->
<script src="{{ asset('assets/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-knob/excanvas.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.js') }}"></script>
  
<script>
  @if (Auth::user()->role=='accountant' || Auth::user()->role=='administrator' || Auth::user()->role=='developer')
  var ctx = document.getElementById("chart2").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
          @foreach($branches as $branch) 
          "{{ $branch->name }}",
          @endforeach
        ],
        datasets: [{
          backgroundColor: [
            @foreach($branches as $branch) 
            "{{ $branch->branch_color }}",
            @endforeach
          ],
          data: [
            @foreach($branches as $branch) 
            @php $clients = App\User::whereBranch($branch->name)->count(); @endphp
            {{ $clients }},
            @endforeach
          ],
          borderWidth: [0, 0]
        }]
      },
    options: {
      maintainAspectRatio: false,
        legend: {
        position :"bottom",	
        display: false,
          labels: {
          fontColor: '#ddd',  
          boxWidth:15
          }
      }
      ,
      tooltips: {
        displayColors:false
      }
        }
  });
  
  var ctx = document.getElementById("chart3").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
          @foreach($branches as $branch) 
          "{{ $branch->name }}",
          @endforeach
        ],
        datasets: [{
          backgroundColor: [
            @foreach($branches as $branch) 
            "{{ $branch->branch_color }}",
            @endforeach
          ],
          data: [
            @foreach($branches as $branch) 
            @php $debts = App\User::whereBranch($branch->name)->sum("balance"); @endphp
            {{ $debts }},
            @endforeach
          ],
          borderWidth: [0, 0]
        }]
      },
    options: {
      maintainAspectRatio: false,
        legend: {
        position :"bottom",	
        display: false,
          labels: {
          fontColor: '#ddd',  
          boxWidth:15
          }
      }
      ,
      tooltips: {
        displayColors:false
      }
        }
  });

  var ctx = document.getElementById("chart4").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
          @foreach($branches as $branch) 
          "{{ $branch->name }}",
          @endforeach
        ],
        datasets: [{
          backgroundColor: [
            @foreach($branches as $branch) 
            "{{ $branch->branch_color }}",
            @endforeach
          ],
          data: [
            @foreach($branches as $branch) 
            @php $pays = App\User::whereBranch($branch->name)->sum("paid"); @endphp
            {{ $pays }},
            @endforeach
          ],
          borderWidth: [0, 0]
        }]
      },
    options: {
      maintainAspectRatio: false,
        legend: {
        position :"bottom",	
        display: false,
          labels: {
          fontColor: '#ddd',  
          boxWidth:15
          }
      }
      ,
      tooltips: {
        displayColors:false
      }
        }
  });


  var ctx = document.getElementById("chart5").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
          @foreach($services as $service) 
          "{{ $service->name }}",
          @endforeach
        ],
        datasets: [{
          backgroundColor: [
            @foreach($services as $service) 
            "{{ $service->color }}",
            @endforeach
          ],
          data: [
            @foreach($services as $service) 
            @php $daily = App\AdminModel\Payment::whereService($service->name)->whereDate('created_at','=',\Carbon\Carbon::today())->sum('paid'); @endphp
            {{ $daily }},
            @endforeach
          ],
          borderWidth: [0, 0]
        }]
      },
    options: {
      maintainAspectRatio: false,
        legend: {
        position :"bottom",	
        display: false,
          labels: {
          fontColor: '#ddd',  
          boxWidth:15
          }
      }
      ,
      tooltips: {
        displayColors:false
      }
        }
  });

  var ctx = document.getElementById("chart6").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
          @foreach($services as $service) 
          "{{ $service->name }}",
          @endforeach
        ],
        datasets: [{
          backgroundColor: [
            @foreach($services as $service) 
            "{{ $service->color }}",
            @endforeach
          ],
          data: [
            @foreach($services as $service) 
            @php $weekly = \App\AdminModel\Payment::whereService($service->name)->whereDate('created_at','>=',\Carbon\Carbon::now()->startOfWeek()->format('Y-m-d'))->whereDate('created_at','<=',\Carbon\Carbon::now()->endOfWeek()->format('Y-m-d'))->sum('paid'); @endphp
            {{ $weekly }},
            @endforeach
          ],
          borderWidth: [0, 0]
        }]
      },
    options: {
      maintainAspectRatio: false,
        legend: {
        position :"bottom",	
        display: false,
          labels: {
          fontColor: '#ddd',  
          boxWidth:15
          }
      }
      ,
      tooltips: {
        displayColors:false
      }
        }
  });

  var ctx = document.getElementById("chart7").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
          @foreach($services as $service) 
          "{{ $service->name }}",
          @endforeach
        ],
        datasets: [{
          backgroundColor: [
            @foreach($services as $service) 
            "{{ $service->color }}",
            @endforeach
          ],
          data: [
            @foreach($services as $service) 
            @php $monthly = \App\AdminModel\Payment::whereService($service->name)->whereMonth('created_at','>=', \Carbon\Carbon::now()->month)->sum('paid'); @endphp
            {{ $monthly }},
            @endforeach
          ],
          borderWidth: [0, 0]
        }]
      },
    options: {
      maintainAspectRatio: false,
        legend: {
        position :"bottom",	
        display: false,
          labels: {
          fontColor: '#ddd',  
          boxWidth:15
          }
      }
      ,
      tooltips: {
        displayColors:false
      }
        }
  });

  var ctx = document.getElementById("chart8").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["IN","OUT"],
        datasets: [{
          backgroundColor: ["#04b962","#7934f3"],
          data: [{{ $sumDailyIn }},{{ $sumDailyOut }}],
          borderWidth: [0, 0]
        }]
      },
    options: {
      maintainAspectRatio: false,
        legend: {
        position :"bottom",	
        display: false,
          labels: {
          fontColor: '#ddd',  
          boxWidth:15
          }
      }
      ,
      tooltips: {
        displayColors:false
      }
        }
  });

  var ctx = document.getElementById("chart9").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["IN","OUT"],
        datasets: [{
          backgroundColor: ["#04b962","#7934f3"],
          data: [{{ $sumWeekIn }},{{ $sumWeekOut }}],
          borderWidth: [0, 0]
        }]
      },
    options: {
      maintainAspectRatio: false,
        legend: {
        position :"bottom",	
        display: false,
          labels: {
          fontColor: '#ddd',  
          boxWidth:15
          }
      }
      ,
      tooltips: {
        displayColors:false
      }
        }
  });

  var ctx = document.getElementById("chart10").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ["IN","OUT"],
        datasets: [{
          backgroundColor: ["#04b962","#7934f3"],
          data: [{{ $sumMonthIn }},{{ $sumMonthOut }}],
          borderWidth: [0, 0]
        }]
      },
    options: {
      maintainAspectRatio: false,
        legend: {
        position :"bottom",	
        display: false,
          labels: {
          fontColor: '#ddd',  
          boxWidth:15
          }
      }
      ,
      tooltips: {
        displayColors:false
      }
        }
  });
  @endif

  @if(Auth::user()->role=='front desk')
  var ctx = document.getElementById("chart11").getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'doughnut',
				data: {
          labels: ["Visitors", "Clients", "Total"],
					datasets: [{
						backgroundColor: [
                "#14abef",
                "#04b962",
                "#f43643"
            ],
						data: [{{ $vp }}, {{ $cp }}, {{ 100-($vp+$cp) }}],
						borderWidth: [0, 0]
					}]
				},
			options: {
				maintainAspectRatio: false,
			   legend: {
				 position :"bottom",	
				 display: false,
				    labels: {
					  fontColor: '#ddd',  
					  boxWidth:15
				   }
				}
				,
				tooltips: {
				  displayColors:false
				}
			   }
    });
  @endif
   
</script>
@endsection