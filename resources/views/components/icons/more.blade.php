@props([
    'action' => '',
    'noteId' => '',
    'wire' => '',
    'clickAction' => ''
])

<i class="fe fe-more-horizontal as-pointer"
    id=""
    wire:model="{{$wire}}"
    onclick="{{$clickAction}}"
    {{$action}}></i>
