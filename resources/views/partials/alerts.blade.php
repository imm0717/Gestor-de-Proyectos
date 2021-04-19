<!-- Wrapping element -->
<div class="fixed-top m-2">
    <!-- Position toasts -->
    <div style="position: absolute; top: 20; right: 10;">
        @if (session()->has('message'))
            <div class="toast alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>
