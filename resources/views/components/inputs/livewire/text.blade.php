@props([
    'id' => '$id',
    'type' => 'text',
    'label' => '$label',
    'name' => '',
    'value' => '',
    'action' => '',
    'class' => '',
    'placeholder' => '',
    'allowLabel' => false,
    'state' => '',
    'isMultiple' => false,
    'inlineError' => false,
    'xClick' => '',
    'inputCss' => 'custom-form-control'
])

<div class="{{$class}}">
    @if ($allowLabel)
    <label for="{{$id}}">{{$label}}</label>
    @endif

    <input type="{{$type ?? 'text'}}"
        class="{{$inputCss}} @if($inlineError) @error($name) inline-error @enderror @endif"
        id="{{$id}}"
        wire:key="{{$label}}_{{$id}}_{{$name}}"
        placeholder="{{!empty($placeholder) ? $placeholder : $label}}"
        wire:model{{$state}}="{{$name}}"
        {{$action}} x-on:click="{{$xClick}}" />

        @if (!$inlineError)
        <div>
            @error($isMultiple ? $name.'*' : $name )
                <span class="error">{{$message}}</span>
            @enderror
        </div>
        @endif
</div>
