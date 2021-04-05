<div>
    @extends('layouts.app')

    @section('content')
            <div class="row">
                    <div class="col-md-12">
                            <livewire:project.index />
                    </div>
            </div>

    @endsection
</div>
@push('styles')
    <link href="{{asset('vendor/custom/datatables/datatables.css')}}" rel="stylesheet" />
    @endpush
@push('scripts')
    <script src="{{ asset('vendor/custom/datatables/datatables.js') }}" type="text/javascript"></script>
    @endpush


