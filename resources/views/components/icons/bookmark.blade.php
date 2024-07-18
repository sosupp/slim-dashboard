@props([
    'action' => '',
    'noteId' => '',
    'wire' => ''
])

<i class="fe fe-bookmark as-pointer"
    id="bookmark"
    {{$action}}
    wire:click="{{$wire}}"></i>
