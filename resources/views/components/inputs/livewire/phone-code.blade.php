@props([
    'action' => '',
    'label' => '$label',
    'allowLabel' => false,
    'phoneCode' => '',
    'phoneCodes' => [],
    'phoneNumber' => ''
])

<div>
    @if ($allowLabel)
    <label for="{{$id}}">{{$label}}</label>
    @endif
    <div class="phone-code-input-wrapper">
        <select class="phone-code-input" id="phoneCode" wire:model="{{$phoneCode}}">

            @foreach ($phoneCodes as $key => $option)
            <option value="">+49</option>
            @endforeach
        </select>

        <input class="phone-number-input"
            wire:model="{{$phoneNumber}}"
            id="phoneNumber"
        />
    </div>
</div>
