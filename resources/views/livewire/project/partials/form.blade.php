<!-- Modal -->
<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                    <h5 class="modal-title" id="exampleModalLabel">
                        @if(!isset($this->project->parent_id) || $this->project->parent_id == null)
                            @if(!isset($this->project->id) || $this->project->id == null)
                                @lang('view.livewire.project.partials.form.create')
                            @else
                                @lang('view.livewire.project.partials.form.update')
                            @endif
                        @else
                            @if(!isset($this->project->id) || $this->project->id == null)
                                @lang('view.livewire.project.partials.form.create-subproject')
                            @else
                                @lang('view.livewire.project.partials.form.update-subproject')
                            @endif
                        @endif
                    </h5>
                <button wire:click.prevent="resetForm()" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            @foreach($locales as $locale)
                                <a wire:ignore class="nav-item nav-link font-weight-bold @if($locale == $default_locale) active @endif" id="nav-{{$locale}}-tab"
                                   data-toggle="tab" href="#nav-{{$locale}}" role="tab" aria-controls="nav-{{$locale}}"
                                   aria-selected="true">{{ strtoupper($locale) }}</a>
                            @endforeach
                        </div>
                    </nav>
                </ul>
                <form wire:submit.prevent="submit">
                    <div class="tab-content" id="nav-tabContent">
                        @foreach($locales as $locale)
                            <div wire:ignore.self class="tab-pane fade border show @if($locale == $default_locale) active @endif" id="nav-{{$locale}}"
                                 role="tabpanel" aria-labelledby="nav-{{$locale}}-tab">
                                <div class="container pt-2">
                                    @if(isset($data[$locale]['parent_name']) && $data[$locale]['parent_name'] != "")
                                    <div class="form-group">
                                        <h4 class="h4">{{ __('Parent Project') }}: {{ $data[$locale]['parent_name'] }}</h4>
                                    </div>
                                    @endif
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
                                            <div wire:ignore class="input-group input-group-sm projectStartDate">
                                                <input type="text"
                                                       class="form-control @error('project.start_date') is-invalid @enderror"
                                                       wire:model.lazy="project.start_date"
                                                       aria-describedby="startdate-calendar">
                                                <div class="input-group-append">
                                                <span class="input-group-text"><span
                                                            class="fa fa-calendar"></span></span>
                                                </div>
                                                @error('project.start_date')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="end_date">{{ __('End Date') }}</label>
                                            <div wire:ignore class="input-group input-group-sm projectEndtDate">
                                                <input type="text"
                                                       class="form-control @error('project.end_date') is-invalid @enderror"
                                                       wire:model.lazy="project.end_date"
                                                       aria-describedby="enddate-calendar">
                                                <div class="input-group-append">
                                                <span class="input-group-text" id="enddate-calendar"><span
                                                            class="fa fa-calendar"></span></span>
                                                </div>
                                                @error('project.end_date')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('Owner')}}</label>
                                        <select class="form-control form-control-sm" wire:model="project.owner_id">
                                            <option value="">{{ __('Select') }}</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
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
