<table id="example" class="table table-striped table-borderless">
    <thead>
        <tr><th colspan="9" class="text-primary"><strong>MONTHLY TRANSACTIONS AS AT {{ \Carbon\Carbon::today()->format('F') }}</strong></th></tr>
        <tr>
            <th>Rec#</th> 
            <th>Pay Date</th> 
            <th>Client ID</th>                      
            <th>Full Name</th>      
            <th>Branch</th>                 
            <th>Mode</th>                
            <th>Payable<small>(GH&#x20B5;)</small></th>          
            <th>Paid<small>(GH&#x20B5;)</small></th>          
            <th>Balance<small>(GH&#x20B5;)</small></th>                    
            <th class="hidden-print">Re-Print</th>
        </tr>
    </thead>
    <tbody>
    @php $total_paid = 0; $total_owe = 0; @endphp
    @if (count($payments))
    @foreach($payments as $pay)
    @php $total_paid += $pay->paid; $total_owe += $pay->owe; @endphp
        <tr class="records">
            <td class="text-primary">{{ $pay->receipt_no }}</td>
            <td>{{ \Carbon\Carbon::parse($pay->created_at)->format('d-M-Y - h:i A') }}</td>
            <td class="text-secondary">{{ $pay->user->student_id }}</td>
            <td>{{ $pay->user->first_name }} {{ $pay->user->last_name }}</td>
            <td>{{ $pay->user->branch }}</td>
            <td>{{ $pay->mode }}</td>
            <td class="text-primary">{{ number_format($pay->payable,2) }}</td>
            <td class="text-success">{{ number_format($pay->paid,2) }}</td>
            <td class="text-danger">{{ number_format($pay->owe,2) }}</td>
            <td class="hidden-print">
                <a href="{{ route('admin.receivepay.receipt', $pay->id) }}" title="Re-print Receipt" data-toggle="tooltip" class="text-primary"><i class="fa fa-print"></i></a>&nbsp;&nbsp;
             </td>
        </tr>
    @endforeach
    @endif    
    </tbody>
    <tfoot>
        <tr>
            <th>Rec#</th> 
            <th>Pay Date</th>           
            <th>Client ID</th>                       
            <th>Full Name</th>  
            <th>Branch</th>                   
            <th>Mode</th>                    
            <th>Payable<small>(GH&#x20B5;)</small></th>          
            <th>Paid<small>(GH&#x20B5;)</small></th>            
            <th>Balance<small>(GH&#x20B5;)</small></th>                        
            <th class="hidden-print hidden-p">Re-Print</th>
        </tr>
    </tfoot>
</table>
<span class="text-success mr-5"><strong>Total Amount Paid: GH&#x20B5; {{ number_format($total_paid,2) }} </strong></span>
<span class="text-danger ml-5"><strong>Total Amount Owe: GH&#x20B5; {{ number_format($total_owe,2) }}</strong></span>

<script>
var table = $('#example').DataTable( {
    lengthChange: false,
    buttons: [
            {
                extend: 'excelHtml5',
                title: 'MONTHLY TRANSACTIONS',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'MONTHLY TRANSACTIONS',
                messageTop: "MONTHLY TRANSACTIONS AS AT {{ \Carbon\Carbon::today()->format('F') }}",
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                }
            },
            {
                extend: 'print',
                title: 'MONTHLY TRANSACTIONS',
                messageTop: "MONTHLY TRANSACTIONS AS AT {{ \Carbon\Carbon::today()->format('F') }}",
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                }
            },
            'colvis'
        ]
} );


table.buttons().container()
.appendTo( '#example_wrapper .col-md-6:eq(0)' );

</script>