<table class="table table-striped table-bordered table-hover table-checkable mb-0 table-sm">
    <tbody>
        @foreach ($childs->get() as $child)
            <tr>
                <td width="10px">{{ $loop_id . '.' . $loop->iteration }}</td>
                <td>{{ $child->name }}</td>
                <td width="10%">{{ $child->start_date }}</td>
                <td width="10%">{{ $child->end_date }}</td>
                <td width="10%">
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            {{ __('Actions') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item"
                                href="{{ route('task.detail', $child->id) }}">{{ __('Details') }}</a>
                            @can('edit-task', $child->project)
                                <a class="dropdown-item" href="#" wire:click="edit('{{ $child->id }}')"
                                    data-toggle="modal" data-target="#taskModal">{{ __('Edit') }}</a>
                            @endcan
                            @can('add-subtask', $child->project)
                                <a class="dropdown-item" href="#" wire:click="resetForm('{{ $child->id }}')"
                                    data-toggle="modal" data-target="#taskModal">{{ __('Add Subtask') }}</a>
                            @endcan
                            @can('delete-task', $child->project)
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
                    <td colspan="5">
                        @include('livewire.task.partials.subtask-list', ['childs' => $child->childs(), 'loop_id' => $loop_id .'.'. $loop->iteration])
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
