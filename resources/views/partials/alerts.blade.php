<!-- Wrapping element -->
<div class="fixed-top m-2">
    <!-- Position toasts -->
    <div style="position: absolute; top: 20; right: 10;">
        @if (session()->has('message'))
            <div class="toast alert alert-primary alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif (session()->has('error'))
        <div class="toast alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>
</div>
