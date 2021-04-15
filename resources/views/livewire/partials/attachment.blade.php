<div>
    

<form wire:submit.prevent="save">
    <input type="file" wire:model="photo">

    @error('photo') <span class="error">{{ $message }}</span> @enderror

    <button type="submit">Save Photo</button>
</form>


</div>
@push('scripts')
<script>
    Livewire.on('fileChoosen', function(){
        console.log($('#attachment'));

    })
</script>
    
@endpush


