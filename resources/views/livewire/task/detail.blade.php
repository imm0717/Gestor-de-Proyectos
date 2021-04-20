<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@lang('view.livewire.task.details.title')</div>
                    <div class="card-body">
                        <form class="">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">{{ __('Project') }}
                                            :</label>
                                        <div class="col-sm-8">
                                            <a class="form-control-plaintext"
                                                href="{{ route('project.detail', $task->project) }}">{{ $task->project->translate($default_locale)->name }}</a>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label font-weight-bold">{{ __('Name') }}
                                            :</label>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext"
                                                value="{{ $task->translate($default_locale)->name }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-4 col-form-label font-weight-bold">{{ __('Responsible') }}
                                            :</label>
                                        <div class="col-sm-8">
                                            <select class="form-control form-control-sm" wire:model="responsible"
                                                @cannot('edit-task', $task->project)
                                                    disabled
                                                @endcannot
                                                >
                                                <option value="">{{ __('Select') }}</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    @if (isset($task->parent))
                                        <div class="form-group row">
                                            <label
                                                class="col-sm-4 col-form-label font-weight-bold">{{ __('Parent Task') }}
                                                :</label>
                                            <div class="col-sm-8">
                                                <a class="form-control-plaintext"
                                                    href="{{ route('task.detail', $task->parent) }}">{{ $task->parent->translate($default_locale)->name }}</a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-4 col-form-label font-weight-bold">{{ __('Start Date') }}
                                            :</label>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext"
                                                value="{{ $task->start_date }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-4 col-form-label font-weight-bold">{{ __('End Date') }}</label>
                                        <div class="col-sm-8">
                                            <input type="text" readonly class="form-control-plaintext"
                                                value="{{ $task->end_date }}">
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
                                        aria-selected="true">@lang('view.livewire.task.details.description_tab')</a>
                                    <a wire:ignore class="nav-item nav-link font-weight-bold" id="nav-tasks-tab"
                                        data-toggle="tab" href="#nav-tasks" role="tab" aria-controls="nav-tasks"
                                        aria-selected="true">@lang('view.livewire.task.details.tasks_tab')</a>
                                    <a wire:ignore class="nav-item nav-link font-weight-bold" id="nav-collaborators-tab"
                                        data-toggle="tab" href="#nav-collaborators" role="tab"
                                        aria-controls="nav-collaborators"
                                        aria-selected="true">@lang('view.livewire.task.details.members_tab')</a>
                                    <a wire:ignore class="nav-item nav-link font-weight-bold" id="nav-files-tab"
                                        data-toggle="tab" href="#nav-files" role="tab" aria-controls="nav-files"
                                        aria-selected="true">@lang('view.livewire.task.details.files_tab')</a>
                                </div>
                            </nav>
                        </ul>
                        <div class="tab-content" id="nav-tabContent">
                            <div wire:ignore.self class="tab-pane fade border show active" id="nav-description"
                                role="tabpanel" aria-labelledby="nav-description-tab">
                                <div class="container pt-2" style="min-height: 150px">
                                    {{ $task->translate($default_locale)->description }}
                                </div>
                            </div>
                            <div wire:ignore.self class="tab-pane fade border show" id="nav-tasks" role="tabpanel"
                                aria-labelledby="nav-files-tab">
                                <div class="container pt-2" style="min-height: 150px">
                                    <livewire:task.index :projectId="$task->project->id" :parentId="$task->id" />
                                </div>
                            </div>
                            <div wire:ignore.self class="tab-pane fade border show" id="nav-collaborators"
                                role="tabpanel" aria-labelledby="nav-collaborators-tab">
                                <div class="container pt-2" style="min-height: 150px">

                                </div>
                            </div>
                            <div wire:ignore.self class="tab-pane fade border show" id="nav-files" role="tabpanel"
                                aria-labelledby="nav-files-tab">
                                <div class="container pt-2" style="min-height: 150px">
                                    <livewire:partials.attachment :model="$task" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
