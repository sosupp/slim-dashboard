@props([
    'id' => '$id',
    'label' => '$label',
    'name' => '',
    'value' => '',
    'action' => '',
    'class' => '',
    'placeholder' => '',
    'body' => ''
])

<div wire:key="course_description" class="{{$class}} custom-input">
    <label for="{{$id}}">{{$label}}</label>
    <textarea data-description="@this"
        id="{{$id}}"
        rows="5"
        name="{{$name}}"
        wire:model="{{$name}}"
        wire:key="{{$id}}_{{$name}}"
        class="form-control"
        {{$action}}
        required></textarea>
</div>
