<div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Users</label>
                <select class="form-control" id="members-user-list" @cannot('edit-project', $project) disabled
                    @endcannot>
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
                                    @php echo implode(", ", json_decode($member->pivot->permission, true)); @endphp
                            </td>
                        @else
                            <select class="form-control form-control-sm selectpicker" multiple wire:model="selected">
                                @foreach ($permissions as $permission)
                                    <option>{{ $permission->permission }}</option>
                                @endforeach
                            </select>
                    @endif
                    <td width="100px">
                        @if ($editedMemberIndex != $index)
                            <button class="btn btn-primary"
                                wire:click="editPermissions({{ $index }}, '{{ $member->pivot->permission }}')"
                                href="#" aria-label="Edit Permission" @cannot('edit-project', $project) disabled
                                @endcannot>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                        @else
                            <button class="btn btn-primary" wire:click="savePermission({{ $member->pivot->user_id }})"
                                href="#" aria-label="Save Permission" 
                                @cannot('edit-project', $project) disabled
                                @endcannot>
                                <i class="fa fa-floppy-o" aria-hidden="true"></i>
                            </button>
                        @endif
                        <button class="btn btn-danger" wire:click="removeMember('{{ $member->pivot->id }}')" href="#"
                            aria-label="Delete" 
                            @cannot('edit-project', $project) disabled @endcannot>
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </button>
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
        window.addEventListener('initSelect', function(event) {
            $('.selectpicker').selectpicker('show');
        })

        window.addEventListener('selectPicker', function(event) {
            $('.selectpicker').selectpicker('val', JSON.parse(event.detail.values));
        })

        $('#members-user-list').on('change', function(e) {
            Livewire.emit('addUserAsMember', $(e.target).val())
        })

    </script>

@endpush
