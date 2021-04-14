<div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Users</label>
                <select class="form-control" name="" id="members-user-list">
                    <option selected>Select</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}"> {{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-8">
            <label for="">Members & Permissions</label>
            <table class="table table-striped table-bordered table-hover table-checkable table-sm">
                <tbody>
                    @foreach ($members as $index => $member)
                        <tr>
                            <td>
                                {{ $member->name }}
                            </td>
                            <td>
                                @if ($editedMemberIndex != $index)
                                    @php echo implode(" | ", json_decode($member->pivot->permission, true)); @endphp
                            </td>
                        @else
                            <select class="form-control form-control-sm">
                                @foreach (json_decode($member->pivot->permission, true) as $permission)
                                    <option>{{ $permission }}</option>
                                @endforeach
                            </select>
                    @endif
                    <td width="100px">
                        @if ($editedMemberIndex != $index)
                            <a class="btn btn-primary" wire:click="editPermissions({{ $index }})" href="#"
                                aria-label="Edit Permission">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </a>
                        @else
                            <a class="btn btn-primary" wire:click="savePermission()" href="#"
                                aria-label="Save Permission">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            </a>
                        @endif
                        <a class="btn btn-danger" wire:click="removeMember('{{ $member->pivot->id }}')" href="#"
                            aria-label="Delete">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $('#members-user-list').on('change', function(e) {
            console.log($(e.target).val())
            Livewire.emit('addUserAsMember', $(e.target).val())
        })

    </script>

@endpush
