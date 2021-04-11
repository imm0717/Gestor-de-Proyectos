<div wire:ignore.self class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">
                    Create Task
                </h5>
                <button wire:click.prevent="$emitSelf('closeTaskModal')" type="button" class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ json_encode($data) }}
                <ul class="nav nav-tabs" id="langTab" role="tablist">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab-lang" role="tablist">
                            @foreach(config('translatable.locales') as $locale)
                                <a wire:ignore
                                   class="nav-item nav-link font-weight-bold @if($locale == config('app.locale')) active @endif"
                                   id="nav-{{$locale}}-tab"
                                   data-toggle="tab" href="#nav-{{$locale}}" role="tab" aria-controls="nav-{{$locale}}"
                                   aria-selected="true">{{ strtoupper($locale) }}</a>
                            @endforeach
                        </div>
                    </nav>
                </ul>
                <form wire:submit.prevent="submit">
                    <div class="tab-content" id="nav-tabContent">
                        @foreach(config('translatable.locales') as $locale)
                            <div wire:ignore.self
                                 class="tab-pane fade border show @if($locale == config('app.locale')) active @endif"
                                 id="nav-{{$locale}}"
                                 role="tabpanel" aria-labelledby="nav-{{$locale}}-tab">
                                <div class="container pt-2">
                                    <div class="form-group">
                                        <label for="name">{{ __('Name') }}</label>
                                        <input type="text"
                                               class="form-control form-control-sm @if($errors->has('data.'.$locale.'.name')) is-invalid @endif"
                                               wire:model="data.{{$locale}}.name">
                                        @if($errors->has('data.'.$locale.'.name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('data.'.$locale.'.name') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group row">
                                        <div class="form-group col-md-6">
                                            <label for="start_date">{{ __('Start Date') }}</label>
                                            <div wire:ignore class="input-group input-group-sm taskStartDate">
                                                <input type="text"
                                                       class="form-control @error('task.start_date') is-invalid @enderror"
                                                       wire:model.lazy="task.start_date"
                                                       aria-describedby="startdate-calendar">
                                                <div class="input-group-append">
                                                <span class="input-group-text"><span
                                                            class="fa fa-calendar"></span></span>
                                                </div>
                                                @error('task.start_date')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="end_date">{{ __('End Date') }}</label>
                                            <div wire:ignore class="input-group input-group-sm taskEndDate">
                                                <input type="text"
                                                       class="form-control @error('task.end_date') is-invalid @enderror"
                                                       wire:model.lazy="task.end_date"
                                                       aria-describedby="enddate-calendar">
                                                <div class="input-group-append">
                                                <span class="input-group-text" id="enddate-calendar"><span
                                                            class="fa fa-calendar"></span></span>
                                                </div>
                                                @error('task.end_date')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="desciption">{{ __('Description') }}</label>
                                        <textarea
                                                class="form-control @if($errors->has('data.'.$locale.'.description')) is-invalid @endif"
                                                id="desciption" rows="3"
                                                wire:model.debounce.500ms="data.{{$locale}}.description"></textarea>
                                        @if($errors->has('data.'.$locale.'.description'))
                                            <div class="invalid-feedback">
                                                {{$errors->first('data.'.$locale.'.description')}}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <button type="button" wire:click="resetForm()" class="btn btn-secondary"
                                    data-dismiss="modal">
                                {{ __('Close') }}
                            </button>
                            <button type="submit" class="btn btn-primary" @if($errors->isNotEmpty()) disabled @endif>
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
