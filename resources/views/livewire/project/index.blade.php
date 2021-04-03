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

                        @if($projects)
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col" width="10px">#</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                    <th scope="col" width="50px">{{ __('Start Date') }}</th>
                                    <th scope="col" width="120px">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                            {{ __('New') }}
                                        </button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td scope="row ">{{ $loop->iteration  }}</td>
                                        <td>{{ $project->name  }}</td>
                                        <td>{{ $project->start_date }}</td>
                                        <td>
                                            <button type="button" wire:click="edit({{$project}})" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                                {{ __('Edit') }}
                                            </button>
                                            <form class="d-inline" method="post" action="">
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
                            {{ __('No Projects') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.project.partials.form');
</div>

