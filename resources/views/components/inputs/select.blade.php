@props([
    'id' => '$id',
    'name' => '',
    'action' => '',
    'currentOption' => '',
    'optionId' => '',
    'optionKey' => '',
    'options' => [],
    'label' => '$label',
    'class' => '',
    'allowLabel' => false,
])

<div class="{{$class}}">
    @if ($allowLabel)
    <label for="{{$id}}">{{$label}}</label>
    @endif
    <select class="custom-form-control"
        id="{{$id}}"
        name="{{$name}}"
        {{$action}}
        value="{{old($name)}}">

        @if (empty($currentOption))
        <option value="">Select {{$label}}</option>
        @endif

        @foreach ($options as $key => $option)
        <option value="{{$option[$optionId]}}"
            {{$option[$optionKey] == $currentOption ? 'selected' : ($option[$optionKey] == old($name) || $option[$optionId] == old($name)  ? 'selected' : '')}}>
            {{Str::ucfirst($option[$optionKey])}}
        </option>
        @endforeach
    </select>

    @error($name)
        <span class="error">{{$message}}</span>
    @enderror
</div>
