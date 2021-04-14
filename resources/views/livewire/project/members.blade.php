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
                    @foreach ($members as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->pivot->id }}</td>
                            <td width="40px">
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ __('Actions') }}
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#"
                                            wire:click="removeMember('{{ $member->pivot->id  }}')">{{ __('Delete') }}</a>
                                    </div>
                                </div>
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
