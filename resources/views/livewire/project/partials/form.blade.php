<!-- Modal -->
<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Create Project</h5>
                <button wire:click.prevent="resetForm()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="submit">
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" class="form-control form-control-sm" id="name" wire:model="project.name">
                    </div>

                    <div class="form-group row">
                        <div class="form-group col-md-6">
                            <label for="start_date">{{ __('Start Date') }}</label>
                            <input type="text" class="form-control form-control-sm" id="start_date" wire:model="project.start_date">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date">{{ __('End Date') }}</label>
                            <input type="text" class="form-control form-control-sm" id="end_date" wire:model="project.end_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desciption">{{ __('Description') }}</label>
                        <textarea class="form-control" id="desciption" rows="3" wire:model="project.description"></textarea>
                    </div>
                    <button type="button" wire:click="resetForm()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
