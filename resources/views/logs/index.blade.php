<div>
    @extends('layouts.app')

    @section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">@lang('view.livewire.logs.index.title')</div>
                                <div class="card-body">
                                    <livewire:logs.index/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</div>
