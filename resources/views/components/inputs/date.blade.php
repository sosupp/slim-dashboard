@props([
    'id' => '$id',
    'label' => '$label',
    'name' => '',
    'action' => '',
    'class' => '',
])

<div {{$attributes->merge(['class' => $class])}}>
    <label for="{{$id}}">{{$label}}</label>

    <input  type="date"
        class="form-control"
        id="{{$id}}"
        name="{{$name}}"
        wire:model="{{$name}}"
        {{$action}} />
</div>
