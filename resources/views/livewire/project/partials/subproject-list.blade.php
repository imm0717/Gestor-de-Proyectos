<table class="table table-striped table-bordered table-hover table-checkable mb-0">
    <tbody>
    @foreach($project_data->childs()->get() as $child)
        <tr>
            <td width="10px">{{ $loop->parent->iteration . "." . $loop->iteration  }}</td>
            <td>{{ $child->name  }}</td>
            <td width="80px">{{ $child->start_date }}</td>
            <td width="130px">
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('Actions') }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" wire:click="edit('{{$child['id']}}')" data-toggle="modal" data-target="#exampleModal">{{ __('Edit') }}</a>
                        <a class="dropdown-item" href="#" wire:click="showDeleteConfirmationModal('{{$child['id']}}')" data-toggle="modal" data-target="#delete_modal">{{ __('Delete') }}</a>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
