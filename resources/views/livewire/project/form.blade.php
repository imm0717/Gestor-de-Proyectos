<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Projects') }}</div>
                    <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" class="form-control form-control-sm" id="name" wire:model="form.name">
                        </div>

                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <label for="start_date">{{ __('Start Date') }}</label>
                                <input type="text" class="form-control form-control-sm" id="start_date" wire:model="form.start_date">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="end_date">{{ __('End Date') }}</label>
                                <input type="text" class="form-control form-control-sm" id="end_date" wire:model="form.end_date">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="desciption">{{ __('Description') }}</label>
                            <textarea class="form-control" id="desciption" rows="3" wire:model="form.description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
