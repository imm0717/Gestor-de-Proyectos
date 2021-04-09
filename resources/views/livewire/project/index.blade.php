<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Projects') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <table class="table table-striped table-bordered table-hover table-checkable" id="project_list_table">
                                <thead>
                                <tr>
                                    <th scope="col" width="10px">#</th>
                                    <th scope="col">@lang('view.livewire.project.index.table.header-name')</th>
                                    <th scope="col" width="80px">@lang('view.livewire.project.index.table.header-startdate')</th>
                                    <th scope="col" width="130px">
                                        <!-- Button trigger modal -->
                                        <button type="button" wire:click="resetForm('8a5bb42a-440a-409f-97db-5877a7c53f3e')" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                            {{ __('New') }}
                                        </button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($projects as $project_data)
                                    <tr>
                                        <td scope="row ">{{ $loop->iteration  }}</td>
                                        <td>{{ $project_data->name  }}</td>
                                        <td>{{ $project_data->start_date }}</td>
                                        <td>
                                            <button type="button" wire:click="edit('{{$project_data['id']}}')" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                                {{ __('Edit') }}
                                            </button>
                                            <button type="button" wire:click="showDeleteConfirmationModal('{{$project_data['id']}}')" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_modal">
                                                {{ __('Delete') }}
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div>
                                                <table class="table table-striped table-bordered table-hover table-checkable">
                                                    <tbody>
                                                        @foreach($project_data->childs()->with('translations')->get() as $child)
                                                            <tr>
                                                                <td width="10px">{{ $loop->parent->iteration . "." . $loop->iteration  }}</td>
                                                                <td>{{ $child->name  }}</td>
                                                                <td width="80px">{{ $child->start_date }}</td>
                                                                <td width="130px">
                                                                    <button type="button" wire:click="edit('{{$child['id']}}')" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                                                        {{ __('Edit') }}
                                                                    </button>
                                                                    <button type="button" wire:click="showDeleteConfirmationModal('{{$child['id']}}')" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_modal">
                                                                        {{ __('Delete') }}
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.project.partials.form');
    @include('partials.delete-modal');
    @include('partials.alerts');
</div>
@push('scripts')
    <script type="text/javascript">
        window.addEventListener('projectStored', () => {
            $('#exampleModal').modal('hide');
        })

        window.addEventListener('closeDeleteModal', () => {
            $('#delete_modal').modal('hide');
        })

        $('.projectStartDate').datetimepicker({
            format: 'DD-MM-YYYY'
        }).on('dp.change', function(ev){
            date = ev.date.format('{{ config('app.front_format') }}');
            Livewire.emit("selectStartDate", date)
        })

        $('.projectEndtDate').datetimepicker({
            format: 'DD-MM-YYYY'
        }).on('dp.change', function(ev){
            date = ev.date.format('{{ config('app.front_format') }}');
            Livewire.emit("selectEndDate", date)
        })


        $(document).ready(function(){
            $(".toast").toast();
        });

    </script>
@endpush
