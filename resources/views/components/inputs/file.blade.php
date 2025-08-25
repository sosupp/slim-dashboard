@props([
    'id' => '$id',
    'label' => '$label',
    'name' => '',
    'action' => '',
    'class' => '',
])

<div {{$attributes->merge(['class' => $class])}}>
    <label for="{{$id}}">{{$label}}</label>

    <input  type="file"
        class="form-control"
        id="{{$id}}"
        name="{{$name}}"
        wire:model="{{$name}}"
        {{$action}} />

    @error($name)
        <span class="error">{{$message}}</span>
    @enderror
</div>
