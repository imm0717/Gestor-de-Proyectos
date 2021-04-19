<table class="table table-striped table-bordered table-hover table-checkable mb-0  table-sm">
    <tbody>
        @foreach ($childs->get() as $child)
            <tr>
                <td width="10px">{{ $loop_id .'.'. $loop->iteration }}</td>
                <td>{{ $child->name }}</td>
                <td width="80px">{{ $child->start_date }}</td>
                <td width="130px">
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item"
                                href="{{ route('project.detail', $child) }}">{{ __('Details') }}</a>
                            @can('edit-project', $child)
                                <a class="dropdown-item" href="#" wire:click="edit('{{ $child['id'] }}')"
                                    data-toggle="modal" data-target="#exampleModal">{{ __('Edit') }}</a>
                            @endcan
                            @can('add-subproject', $child)
                                <a class="dropdown-item" href="#" wire:click="resetForm('{{ $child['id'] }}')"
                                    data-toggle="modal" data-target="#exampleModal">{{ __('Add Subproject') }}</a>
                            @endcan
                            @can('delete-project', $child)
                                <a class="dropdown-item" href="#"
                                    wire:click="showDeleteConfirmationModal('{{ $child['id'] }}')" data-toggle="modal"
                                    data-target="#delete_modal">{{ __('Delete') }}</a>
                            @endcan
                        </div>
                    </div>
                </td>
            </tr>
            @if ($child->childs()->count() > 0)
                <tr>
                    <td colspan="4">
                        @include('livewire.project.partials.subproject-list', ['childs' => $child->childs(), 'loop_id' => $loop_id .'.'. $loop->iteration])
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
