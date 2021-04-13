<div>
    {{ session('message') }}
    <table class="table table-striped table-bordered table-hover table-checkable table-sm" id="task_list_table">
        <thead>
            <tr>
                <th scope="col" width="10px">#</th>
                <th scope="col">@lang('view.livewire.task.index.table.header-name')</th>
                <th scope="col" width="80px">@lang('view.livewire.task.index.table.header-startdate')</th>
                <th scope="col" width="80px">@lang('view.livewire.task.index.table.header-enddate')</th>
                <th scope="col" width="130px">
                    <!-- Button trigger modal -->
                    <button type="button" wire:click="resetForm" class="btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#taskModal">
                        {{ __('New') }}
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task_data)
                <tr>
                    <td scope="row ">{{ $loop->iteration }}</td>
                    <td>{{ $task_data->name }}</td>
                    <td>{{ $task_data->start_date }}</td>
                    <td>{{ $task_data->end_date }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{ __('Actions') }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" wire:click="edit('{{ $task_data['id'] }}')"
                                    data-toggle="modal" data-target="#taskModal">{{ __('Edit') }}</a>
                                <a class="dropdown-item" href="#" wire:click="resetForm('{{ $task_data['id'] }}')"
                                    data-toggle="modal" data-target="#taskModal">{{ __('Add Subtask') }}</a>
                                <a class="dropdown-item" href="#"
                                    wire:click="showDeleteConfirmationModal('{{ $task_data['id'] }}')"
                                    data-toggle="modal" data-target="#delete_modal">{{ __('Delete') }}</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @if ($task_data->childs()->count() > 0)
                    <tr>
                        <td colspan="5">
                            @include('livewire.task.partials.subtask-list')
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    {{ $tasks->links() }}
    @include('livewire.task.partials.form')
    @include('partials.delete-modal')
</div>
@push('scripts')
    <script type="text/javascript">
        window.addEventListener('showModal', () => {
            $('#taskModal').modal('show');
        })

        window.addEventListener('closeModal', () => {
            $('#taskModal').modal('hide');
        })

        window.addEventListener('closeDeleteModal', () => {
            $('#delete_modal').modal('hide');
        })

        $('.taskStartDate').datetimepicker({
            format: 'DD-MM-YYYY'
        }).on('dp.change', function(ev) {
            date = ev.date.format('{{ config('app.front_format') }}');
            Livewire.emit("selectStartDate", date)
        })

        $('.taskEndDate').datetimepicker({
            format: 'DD-MM-YYYY'
        }).on('dp.change', function(ev) {
            date = ev.date.format('{{ config('app.front_format') }}');
            Livewire.emit("selectEndDate", date)
        })

    </script>
@endpush
