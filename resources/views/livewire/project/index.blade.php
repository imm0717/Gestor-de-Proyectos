<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@lang('view.livewire.project.index.title')</div>
                    <div class="card-body">
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
                                    <th scope="col" width="80px">@lang('view.livewire.project.index.table.header-startdate')</th>
                                    <th scope="col" width="130px">
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
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{ __('Actions') }}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="{{ route('project.detail', $project_data) }}">{{ __('Details') }}</a>
                                                    <a class="dropdown-item" href="#" wire:click="edit('{{$project_data['id']}}')" data-toggle="modal" data-target="#exampleModal">{{ __('Edit') }}</a>
                                                    <a class="dropdown-item" href="#" wire:click="resetForm('{{$project_data['id']}}')" data-toggle="modal" data-target="#exampleModal" >{{ __('Add Subproject') }}</a>
                                                    <a class="dropdown-item" href="#" wire:click="showDeleteConfirmationModal('{{$project_data['id']}}')" data-toggle="modal" data-target="#delete_modal">{{ __('Delete') }}</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @if($project_data->childs()->count() > 0)
                                    <tr>
                                        <td colspan="4">
                                            @include('livewire.project.partials.subproject-list')
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            {{ $projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.project.partials.form')
    @include('partials.delete-modal')
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
