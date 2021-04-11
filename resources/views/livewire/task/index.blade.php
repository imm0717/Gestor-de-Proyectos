<div>
    {{ session('message') }}
    <table class="table table-striped table-bordered table-hover table-checkable" id="task_list_table">
        <thead>
        <tr>
            <th scope="col" width="10px">#</th>
            <th scope="col">Task</th>
            <th scope="col" width="80px">Name</th>
            <th scope="col" width="130px">
                <!-- Button trigger modal -->
                <button type="button" wire:click="resetForm" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#taskModal">
                    {{ __('New') }}
                </button>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tasks as $task_data)
            <tr>
                <td scope="row ">{{ $loop->iteration  }}</td>
                <td>{{ $task_data->name  }}</td>
                <td>{{ $task_data->start_date }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#" wire:click="edit('{{$task_data['id']}}')"
                               data-toggle="modal"
                               data-target="#exampleModal">{{ __('Edit') }}</a>
                            <a class="dropdown-item" href="#" wire:click="resetForm('{{$task_data['id']}}')"
                               data-toggle="modal" data-target="#exampleModal">{{ __('Add Subproject') }}</a>
                            <a class="dropdown-item" href="#"
                               wire:click="showDeleteConfirmationModal('{{$task_data['id']}}')" data-toggle="modal"
                               data-target="#delete_modal">{{ __('Delete') }}</a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $tasks->links() }}

    @include('livewire.task.partials.form')
</div>
@push('scripts')
    <script type="text/javascript">
        window.addEventListener('showModal', () => {
            $('#taskModal').modal('show');
        })

        window.addEventListener('closeModal', () => {
            $('#taskModal').modal('hide');
        })

        $('.taskStartDate').datetimepicker({
            format: 'DD-MM-YYYY'
        }).on('dp.change', function(ev){
            date = ev.date.format('{{ config('app.front_format') }}');
            Livewire.emit("selectStartDate", date)
        })

        $('.taskEndDate').datetimepicker({
            format: 'DD-MM-YYYY'
        }).on('dp.change', function(ev){
            date = ev.date.format('{{ config('app.front_format') }}');
            Livewire.emit("selectEndDate", date)
        })
    </script>
@endpush


