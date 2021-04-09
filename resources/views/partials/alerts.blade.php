<!-- Wrapping element -->
<div class="fixed-bottom m-2">
    <!-- Position toasts -->
    <div style="position: absolute; bottom: 0; right: 0;">
        @if(session()->has('message'))
        <div class="toast fade show alert alert-info" data-delay="2000" style="width: 300px">
            <div class="toast-header">
                <strong class="mr-auto"><i class="fa fa-globe"></i> Hello, world!</strong>
                <small class="text-muted">{{ \Illuminate\Support\Carbon::now()->format('d-m-Y') }}</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
            </div>
            <div class="toast-body">
                {{ session('message') }}
            </div>
        </div>
        @endif
    </div>
</div>
