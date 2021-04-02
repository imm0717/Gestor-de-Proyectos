<div>
    @extends('layouts.app')

    @section('content')
            <div class="row">
                    <div class="col-md-6">
                            <livewire:project.index />
                    </div>
                    <div class="col-md-6">
                            <livewire:project.form />
                    </div>
            </div>

    @endsection

</div>
