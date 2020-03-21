    <li class="list-group-item d-flex justify-content-between align-items-center">
    You have {{ count($users) }} Notifications
    <span class="badge badge-info">{{ count($users) }}</span>
    </li>
    @if(count($users))
    @foreach ($users as $item)
    <li class="list-group-item records">
        <a href="javaScript:void();">
        <div class="media">
            <i class="fa fa-dollar fa-2x mr-3 text-info"></i>
            <div class="media-body">
                <h6 class="mt-0 msg-title">Discount approval</h6>
                <p class="msg-info">{{ $item->first_name }} {{ $item->last_name }} </p>
                <i class="fa fa-check text-success icon-clickable btnApprove" data-id="{{ $item->id }}"></i>
                <i class="fa fa-times text-danger ml-4 icon-clickable btnRemove" data-id="{{ $item->id }}"></i>
            </div>
        </div>
        </a>
    </li>
    @endforeach
    @else
    <li class="list-group-item">
        <a href="javaScript:void();">
        <div class="media">
            <i class="fa fa-dollar fa-2x mr-3 text-info"></i>
            <div class="media-body">
                <p class="msg-info text-danger">Not available</p>
            </div>
        </div>
        </a>
    </li>
    @endif
    
    <li class="list-group-item text-center"></li>

    <script>
        $(".btnApprove").on("click", function(e){
            e.preventDefault();
            e.stopPropagation();
            var $this = $(this);
            var id = $this.data('id');
            $.ajax({
                url: "{{ route('admin.discount.approve') }}",
                type: "POST",
                data: {id:id},
                success: function(resp){
                    if(resp=='success'){
                        console.log('Successful');
                    }
                    else{
                        alert(resp);
                    }
                },
                error: function(resp){
                    console.log("Something went wrong");
                }
            })
            return false;
        });
        $(".btnRemove").on("click", function(e){
            e.preventDefault();
            e.stopPropagation();
            var $this = $(this);
            var id = $this.data('id');
            $.ajax({
                url: "{{ route('admin.discount.reject') }}",
                type: "POST",
                data: {id:id},
                success: function(resp){
                    console.log(resp);
                },
                error: function(resp){
                    console.log("Something went wrong");
                }
            })
            return false;
        });
    </script>