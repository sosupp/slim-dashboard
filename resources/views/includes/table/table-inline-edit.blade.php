@if ($colHeading['sidePanel'])
<span class="as-pointer"
    x-on:click="toggleSidePanel('{{$colHeading['sideView']}}', '{{$colHeading['panelHeading']}}', {{$record->id}})">
    <x-icons.edit w="12" class="inline-is-inactive"/>
    {{-- <input type="text" class="inline-edit-input" wire:model=""> --}}
</span>
@else

@endif
