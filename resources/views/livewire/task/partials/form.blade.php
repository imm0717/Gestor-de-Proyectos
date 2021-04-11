<div wire:ignore.self class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="taskModalLabel">
                </h5>
                <button wire:click.prevent="$emitSelf('closeTaskModal')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button type="button" wire:click="$emit('closeTaskModal')">Test</button>
            </div>
        </div>
    </div>
</div>
