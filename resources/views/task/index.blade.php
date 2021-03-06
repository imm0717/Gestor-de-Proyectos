<div>
    @extends('layouts.app')

    @section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">@lang('view.livewire.task.index.title')</div>
                                <div class="card-body">
                                    <livewire:task.index :projectId="null" :parentId="null" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</div>
