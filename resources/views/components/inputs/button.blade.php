<div class="custom-btn-wrapper">
    @props([
    'id' => '$id',
    'class' => '$class',
    'action' => '$action',
    'wire' => '$wire',
    'label' => '$label',
    ])

    <button
        id="{{$id}}"
        class="{{$class}} custom-action-btn"
        {{$action}}
        wire:click.prevent="{{$wire}}"
        >{{$label}}</button>
</div>
