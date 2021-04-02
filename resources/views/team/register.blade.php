@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Team Form') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <form method="post" action="{{ route('team.update', ['team' => $team]) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">{{__('Name') }}</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $team->name) }}">
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="active" name="active" value="1" {{ ($team->active) ? 'checked="checked"' : '' }}>
                                    <label class="form-check-label" for="exampleCheck1">Active</label>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
