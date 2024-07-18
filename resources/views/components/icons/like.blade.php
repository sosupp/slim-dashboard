@props([
    'action' => '',
    'noteId' => '',
    'wire' => '',
    'class' => ''
])

<i class="fe fe-thumbs-up as-pointer feather {{$class}}"
    id="like"
    {{$action}}
    wire:click="{{$wire}}"></i>
