<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@lang('view.livewire.project.details.title')</div>
                    <div class="card-body">
                        <form class="">
                            <div class="row">
                                <div class="col-6">
                                    @if (isset($project->parent))
                                        <div class="form-group row">
                                            <label
                                                class="col-sm-4 col-form-label font-weight-bold">{{ __('Parent Project') }}
                                                :</label>
                                            <div class="col-sm-8">
                                                <a class="form-control-plaintext"
                                                    href="{{ route('project.detail', $project->parent) }}">{{ $project->parent->translate($default_locale)->name }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">{{ __('Name') }}
                                            :</label>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext"
                                                value="{{ $project->translate($default_locale)->name }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">{{ __('Owner') }}
                                            :</label>
                                        <div class="col-sm-8">
                                            <select class="form-control form-control-sm" id="owner" wire:model="owner"
                                                @cannot('edit-project', $project) disabled @endcannot>
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">{{ __('Start Date') }}
                                            :</label>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext"
                                                value="{{ $project->start_date }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-4 col-form-label font-weight-bold">{{ __('End Date') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext"
                                                value="{{ $project->end_date }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a wire:ignore class="nav-item nav-link font-weight-bold active"
                                        id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab"
                                        aria-controls="nav-description"
                                        aria-selected="true">@lang('view.livewire.project.details.description_tab')</a>
                                    <a wire:ignore class="nav-item nav-link font-weight-bold" id="nav-subprojects-tab"
                                        data-toggle="tab" href="#nav-subprojects" role="tab"
                                        aria-controls="nav-subprojects"
                                        aria-selected="true">@lang('view.livewire.project.details.subprojects_tab')</a>
                                    <a wire:ignore class="nav-item nav-link font-weight-bold" id="nav-tasks-tab"
                                        data-toggle="tab" href="#nav-tasks" role="tab" aria-controls="nav-tasks"
                                        aria-selected="true">@lang('view.livewire.project.details.tasks_tab')</a>
                                    <a wire:ignore class="nav-item nav-link font-weight-bold" id="nav-collaborators-tab"
                                        data-toggle="tab" href="#nav-collaborators" role="tab"
                                        aria-controls="nav-collaborators"
                                        aria-selected="true">@lang('view.livewire.project.details.members_tab')</a>
                                    <a wire:ignore class="nav-item nav-link font-weight-bold" id="nav-files-tab"
                                        data-toggle="tab" href="#nav-files" role="tab" aria-controls="nav-files"
                                        aria-selected="true">@lang('view.livewire.project.details.files_tab')</a>
                                </div>
                            </nav>
                        </ul>
                        <div class="tab-content" id="nav-tabContent">
                            <div wire:ignore.self class="tab-pane fade border show active" id="nav-description"
                                role="tabpanel" aria-labelledby="nav-description-tab">
                                <div class="container pt-2" style="min-height: 150px">
                                    {{ $project->translate($default_locale)->description }}
                                </div>
                            </div>
                            <div wire:ignore.self class="tab-pane fade border show" id="nav-subprojects"
                                role="tabpanel" aria-labelledby="nav-subprojects-tab">
                                <div class="container pt-2" style="min-height: 150px">
                                    <livewire:project.index :parentId="$project->id"/>
                                </div>
                            </div>
                            <div wire:ignore.self class="tab-pane fade border show" id="nav-tasks" role="tabpanel"
                                aria-labelledby="nav-files-tab">
                                <div class="container pt-2" style="min-height: 150px">
                                    <livewire:task.index :projectId="$project->id" :parentId="null" />
                                </div>
                            </div>
                            <div wire:ignore.self class="tab-pane fade border show" id="nav-collaborators"
                                role="tabpanel" aria-labelledby="nav-collaborators-tab">
                                <div class="container pt-2" style="min-height: 150px">
                                    <livewire:project.members :project="$project" />
                                </div>
                            </div>
                            <div wire:ignore.self class="tab-pane fade border show" id="nav-files" role="tabpanel"
                                aria-labelledby="nav-files-tab">
                                <div class="container pt-2" style="min-height: 150px">
                                    <livewire:partials.attachment :model="$project" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.alerts')
</div>

