<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Teams') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if($teams)
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col" width="5%">#</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col" width="20%">{{ __('State') }}</th>
                                    <th scope="col" width="20%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($teams as $team)
                                    <tr>
                                        <td scope="row ">{{ $loop->iteration  }}</td>
                                        <td>{{ $team->name  }}</td>
                                        <td>{{ ($team->active) ? __('Active') : __('inactive')  }}</td>
                                        <td>
                                            <form class="d-inline" method="post" action="{{ route('team.edit', ['team'=> $team]) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">{{ __('Edit') }}</button>
                                            </form>
                                            <form class="d-inline" method="post" action="{{ route('team.delete', ['team'=> $team]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-secondary btn-sm">{{ __('Remove') }}</button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            {{ __('No Teams') }}
                        @endif
                        {{ $teams->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
