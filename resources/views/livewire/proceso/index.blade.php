<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@lang('view.livewire.process.index.title')</div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover table-checkable table-sm"
                            id="project_list_table">
                            <thead>
                                <tr>
                                    <th scope="col" width="10px">#</th>
                                    <th scope="col">@lang('view.livewire.process.index.table.header-name')</th>
                                    <th scope="col" width="130px">
                                        <button type="button" wire:click="resetForm()" class="btn btn-primary btn-sm"
                                            data-toggle="modal" data-target="#exampleModal">
                                            {{ __('New') }}
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($processes as $process_data)
                                    <tr>
                                        <td scope="row ">{{ $loop->iteration }}</td>
                                        <td> {{ $process_data->name }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{ __('Actions') }}
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#"
                                                        wire:click="edit('{{ $process_data->id }}')" data-toggle="modal"
                                                        data-target="#exampleModal">{{ __('Edit') }}</a>
                                                    <a class="dropdown-item" href="#"
                                                        wire:click="resetForm('{{ $process_data->id }}')"
                                                        data-toggle="modal"
                                                        data-target="#exampleModal">{{ __('Add Subprocess') }}</a>
                                                    <a class="dropdown-item" href="#"
                                                        wire:click="showDeleteConfirmationModal('{{ $process_data->id }}')"
                                                        data-toggle="modal"
                                                        data-target="#delete_modal">{{ __('Delete') }}</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @if ($process_data->childs()->count() > 0)
                                        <tr>
                                            <td colspan="3">
                                                @include('livewire.proceso.partials.subproceso-list', ['childs' =>
                                                $process_data->childs, 'loop_id' => $loop->iteration ])
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        {{ $processes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.proceso.partials.form')

    <livewire:partials.delete-modal :modalId="$deleteModalId">
</div>
@push('scripts')
    <script type="text/javascript">
        window.addEventListener('processStored', () => {
            $('#exampleModal').modal('hide');
        })

        $(document).ready(function() {
            $(".toast").toast();
        });

    </script>
@endpush
