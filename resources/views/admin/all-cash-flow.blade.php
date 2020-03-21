<table id="example" class="table table-striped table-borderless">
    <thead>
        <tr><th colspan="9" class="text-primary"><strong>ALL CASH FLOW AS AT {{ \Carbon\Carbon::now()->format('d-M-Y') }}</strong></th></tr>
        <tr>
            <th>Rec#</th> 
            <th>Pay Date</th>  
            <th>Branch</th>                    
            <th>Flow</th>               
            <th>Payable<small>(GH&#x20B5;)</small></th>          
            <th>Paid<small>(GH&#x20B5;)</small></th>          
            <th>Balance<small>(GH&#x20B5;)</small></th>        
        </tr>
    </thead>
    <tbody>
    @php $total_paid = 0; $total_owe = 0; @endphp
    @if (count($payments))
    @foreach($payments as $pay)
    @php 
        $total_paid += $pay->paid; $total_owe += $pay->owe; 
        $service = \App\AdminModel\Course::whereName($pay->service)->first();
    @endphp
        <tr class="records">
            <td class="text-primary">{{ $pay->receipt_no }}</td>
            <td>{{ \Carbon\Carbon::parse($pay->created_at)->format('d-M-Y - h:i A') }}</td>
            <td>{{ $pay->user->branch }}</td>
            <td>
                @if (!empty($service))
                    {{ $service->status? 'IN':'OUT' }}
                @endif
            </td>
            <td class="text-primary">{{ number_format($pay->payable,2) }}</td>
            <td class="text-success">{{ number_format($pay->paid,2) }}</td>
            <td class="text-danger">{{ number_format($pay->owe,2) }}</td>
        </tr>
    @endforeach
    @endif    
    </tbody>
    <tfoot>
        <tr>
            <th>Rec#</th> 
            <th>Pay Date</th>        
            <th>Branch</th>                     
            <th>Flow</th>                 
            <th>Payable<small>(GH&#x20B5;)</small></th>          
            <th>Paid<small>(GH&#x20B5;)</small></th>            
            <th>Balance<small>(GH&#x20B5;)</small></th>          
        </tr>
    </tfoot>
</table>

<script>
var table = $('#example').DataTable( {
    lengthChange: false,
    buttons: [
            {
                extend: 'excelHtml5',
                title: 'ALL CASH FLOW',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'pdfHtml5',
                title: 'ALL CASH FLOW',
                messageTop: "ALL CASH FLOW AS AT {{ \Carbon\Carbon::now()->format('d-M-Y') }}",
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'print',
                title: 'ALL CASH FLOW',
                messageTop: "ALL CASH FLOW AS AT {{ \Carbon\Carbon::now()->format('d-M-Y') }}",
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }
            },
            'colvis'
        ]
} );

table.buttons().container()
.appendTo( '#example_wrapper .col-md-6:eq(0)' );

</script>