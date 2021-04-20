<div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <table class="table table-striped table-bordered table-hover table-checkable table-sm" id="project_list_table">
        <thead>
            <tr>
                <th scope="col" width="10px">#</th>
                <th scope="col">@lang('view.livewire.project.index.table.header-name')</th>
                <th scope="col" width="10%">@lang('view.livewire.project.index.table.header-startdate')</th>
                <th scope="col" width="10%">
                    @if ($parent_id == '')
                        <button type="button" wire:click="resetForm('{{ $parent_id }}')"
                            class="btn btn-primary btn-sm" data-toggle="modal" data-target="#projectModal">
                            {{ __('New') }}
                        </button>
                    @else
                        @can('add-subproject', $project)
                            <button type="button" wire:click="resetForm('{{ $parent_id }}')"
                                class="btn btn-primary btn-sm" data-toggle="modal" data-target="#projectModal">
                                {{ __('New') }}
                            </button>
                        @endcan

                    @endif


                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project_data)
                <tr>
                    <td scope="row ">{{ $loop->iteration }}</td>
                    <td>{{ $project_data->name }}</td>
                    <td>{{ $project_data->start_date }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{ __('Actions') }}
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item"
                                    href="{{ route('project.detail', $project_data) }}">{{ __('Details') }}</a>
                                @can('edit-project', $project_data)
                                    <a class="dropdown-item" href="#" wire:click="edit('{{ $project_data['id'] }}')"
                                        data-toggle="modal" data-target="#projectModal">{{ __('Edit') }}</a>
                                @endcan
                                @can('add-subproject', $project_data)
                                    <a class="dropdown-item" href="#" wire:click="resetForm('{{ $project_data['id'] }}')"
                                        data-toggle="modal" data-target="#projectModal">{{ __('Add Subproject') }}</a>
                                @endcan
                                @can('delete-project', $project_data)
                                    <a class="dropdown-item" href="#"
                                        wire:click="showDeleteConfirmationModal('{{ $project_data['id'] }}')"
                                        data-toggle="modal" data-target="#delete_modal">{{ __('Delete') }}</a>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
                @if ($project_data->childs()->count() > 0)
                    <tr>
                        <td colspan="4">
                            @include('livewire.project.partials.subproject-list', ['childs' => $project_data->childs(),
                            'loop_id' => $loop->iteration])
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    {{ $projects->links() }}
    @include('livewire.project.partials.form')
    @include('partials.alerts')

    <livewire:partials.delete-modal :modalId="$deleteModalId" />
</div>
@push('scripts')
    <script type="text/javascript">
        function initCalendar() {
            $('.projectStartDate').datetimepicker({
                format: 'DD-MM-YYYY'
            }).on('dp.change', function(ev) {
                date = ev.date.format('{{ config('app.front_format') }}');
                Livewire.emit("selectProjectStartDate", date)
            })

            $('.projectEndtDate').datetimepicker({
                format: 'DD-MM-YYYY'
            }).on('dp.change', function(ev) {
                date = ev.date.format('{{ config('app.front_format') }}');
                Livewire.emit("selectProjectEndDate", date)
            })
        }

        window.addEventListener('projectStored', () => {
            $('#projectModal').modal('hide');
        })

        window.addEventListener('initCalendar', function() {
            initCalendar();
        })

    </script>
@endpush
