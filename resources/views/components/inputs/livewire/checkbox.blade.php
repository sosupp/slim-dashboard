@props([
    'id' => '$id',
    'label' => '$label',
    'name' => '',
    'value' => '',
    'action' => '',
    'class' => '',
    'placeholder' => '',
    'allowLabel' => false,
    'checked' => "",
    'state' => "",
])

<label class="{{$class}}"
    for="{{$id}}">
    <input type="checkbox"
        wire:model.{{$state}}="{{$name}}"
        {{$checked}}
        {{$action}}
        id="{{$id}}"
        class="checkbox-input">
    <span>{{$label}}</span>
</label>
