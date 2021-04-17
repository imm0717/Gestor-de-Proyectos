<div class="container">
    <form wire:submit.prevent='save'>
        <div class="form-group row">
            <input type="file" wire:model="file" @cannot('attach-file', $this->model) disabled @endcannot>
            @error('file')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            <button class="btn btn-primary btn-sm" type="submit" title="Upload" @if (!isset($file)) disabled @endif><i class="fa fa-upload"
                    aria-hidden="true"></i></button>
        </div>
    </form>
    <div class="d-flex align-items-start flex-row bd-highlight mb-3 flex-wrap">
        @foreach ($attachments as $attachment)
            <div class="m-2" style="width: 100px" wire:click="download('{{ basename($attachment->file_path) }}')">
                @can('remove-file', $this->model)
                    <button type="button" class="close" aria-label="Close" wire:click="remove({{ $attachment->id }})">
                        <span aria-hidden="true">&times;</span>
                    </button>
                @endcan
                @if (array_key_exists($attachment->extension, $extensions_logo))
                    <li class="{{ $extensions_logo[$attachment->extension] }} fa-4x"></li>
                @else
                    <li class="fa fa-file fa-4x"></li>
                @endif

                <div>{{ basename($attachment->file_path) }}</div>
            </div>
        @endforeach
    </div>
</div>
