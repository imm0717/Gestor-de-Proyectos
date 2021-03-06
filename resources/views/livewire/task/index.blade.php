<div>
    <table class="table table-striped table-bordered table-hover table-checkable table-sm" id="task_list_table">
        <thead>
            <tr>
                <th scope="col" width="10px">#</th>
                <th scope="col">@lang('view.livewire.task.index.table.header-name')</th>
                <th scope="col">@lang('view.livewire.task.index.table.header-project')</th>
                <th scope="col" width="10%">@lang('view.livewire.task.index.table.header-startdate')</th>
                <th scope="col" width="10%">@lang('view.livewire.task.index.table.header-enddate')</th>
                <th scope="col" width="10%">
                    <!-- Button trigger modal -->
                    @if ($project_id != null)
                        @if ($parent_id != null && $parent_id != '')
                            @can('add-subtask', $project)
                                <button type="button" wire:click="resetForm('{{ $parent_id }}')"
                                    class="btn btn-primary btn-sm" data-toggle="modal" data-target="#taskModal">
                                    {{ __('New') }}
                                </button>
                            @endcan
                        @else
                            @can('add-task', $project)
                                <button type="button" wire:click="resetForm('{{ $parent_id }}')"
                                    class="btn btn-primary btn-sm" data-toggle="modal" data-target="#taskModal">
                                    {{ __('New') }}
                                </button>
                            @endcan
                        @endif
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task_data)
                <tr>
                    <td scope="row ">{{ $loop->iteration }}</td>
                    <td>{{ $task_data->name }}</td>
                    <td>{{ $task_data->project->name }}</td>
                    <td>{{ $task_data->start_date }}</td>
                    <td>{{ $task_data->end_date }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{ __('Actions') }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item"
                                    href="{{ route('task.detail', $task_data->id) }}">{{ __('Details') }}</a>
                                @if ($project_id != null)
                                    @can('edit-task', $task_data->project)
                                        <a class="dropdown-item" href="#" wire:click="edit('{{ $task_data->id }}')"
                                            data-toggle="modal" data-target="#taskModal">{{ __('Edit') }}</a>
                                    @endcan
                                    @can('add-subtask', $task_data->project)
                                        <a class="dropdown-item" href="#" wire:click="resetForm('{{ $task_data->id }}')"
                                            data-toggle="modal" data-target="#taskModal">{{ __('Add Subtask') }}</a>
                                    @endif
                                    @can('delete-task', $task_data->project)
                                        <a class="dropdown-item" href="#"
                                            wire:click="showDeleteConfirmationModal('{{ $task_data->id }}')"
                                            data-toggle="modal" data-target="#delete_modal">{{ __('Delete') }}</a>
                                    @endcan
                @endif

    </div>
    </div>
    </td>
    </tr>
    @if ($task_data->childs()->count() > 0 && $project_id != null)
        <tr>
            <td colspan="6">
                @include('livewire.task.partials.subtask-list', ['childs' => $task_data->childs(), 'loop_id' =>
                $loop->iteration])
            </td>
        </tr>
    @endif
    @endforeach
    </tbody>
    </table>
    {{ $tasks->links() }}
    @include('livewire.task.partials.form')

    <livewire:partials.delete-modal :modalId="$deleteModalId" />
    @include('partials.alerts')

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
