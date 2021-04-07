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
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col" width="80px">{{ __('Start Date') }}</th>
                                    <th scope="col" width="120px">
                                        <!-- Button trigger modal -->
                                        <button type="button" wire:click="resetForm()" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
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
</div>
@push('scripts')
    <script type="text/javascript">
        window.addEventListener('projectStored', () => {
            $('#exampleModal').modal('hide');
        });

        window.addEventListener('closeDeleteModal', () => {
            $('#delete_modal').modal('hide');
        });

        $(".start_date").datetimepicker({
            format: 'dd-mm-yyyy',
            startView: 2,
            minView: 2
        }).on('changeDate', function(ev){
            $date = ev.date.getTime()/1000;
            Livewire.emit("selectStartDate", $date)
        });

        $(".end_date").datetimepicker({
            format: 'dd-mm-yyyy',
            startView: 2,
            minView: 2
        }).on('changeDate', function(ev){
            $date = ev.date.getTime()/1000;
            Livewire.emit("selectEndDate", $date)
            //@this.set('project.end_date', $date);
        });

    </script>
@endpush
