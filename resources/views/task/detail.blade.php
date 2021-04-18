<div>
    @extends('layouts.app')

    @section('content')
        <div class="row">
            <div class="col-md-12">
                <livewire:task.detail :task="$task" />
            </div>
        </div>

    @endsection
</div>