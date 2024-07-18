@props([
    'action' => '',
    'noteId' => '',
    'wire' => '',
])

<i class="fe fe-message-square"
    id="saveLater"
    {{$action}}
    wire:click="{{$wire}}"></i>
