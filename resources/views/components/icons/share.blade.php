@props([
    'action' => '',
    'noteId' => '',
    'wire' => ''
])

<i class="fe fe-share-2 as-pointer"
    id="generalShare"
    {{$action}}
    wire:click="{{$wire}}"></i>
