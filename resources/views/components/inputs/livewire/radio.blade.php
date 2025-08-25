@props([
    'id' => '$id',
    'label' => '$label',
    'name' => '',
    'value' => '',
    'action' => '',
    'class' => '',
    'placeholder' => '',
    'allowLabel' => false,
    'checked'=> "",
    'state'=> "",
])

<label class="custom-radio-checkbox {{$class}}"
    for="{{$id}}">
    <div>
        <input type="radio"
            wire:model.{{$state}}="{{$name}}"
            {{$checked}}
            {{$action}}
            id="{{$id}}"
            class="radio-input"
            value="{{$value}}">
        <span class="radio-checkmark"></span>
    </div>

    <span>{{$label}}</span>
</label>
