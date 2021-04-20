<div wire:ignore.self class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ $message }}</p>
            </div>
            <div class="modal-footer">
                <button wire:click="$emitUp('delete')" type="button" class="btn btn-danger"
                    id="btn_confirm">{{ __('Delete') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        window.addEventListener('show{{ $modalId }}', () => {
            $('#{{ $modalId }}').modal('show');
        })
        window.addEventListener('close{{ $modalId }}', () => {
            $('#{{ $modalId }}').modal('hide');
        })
    </script>

@endpush
