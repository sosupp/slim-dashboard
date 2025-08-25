@props([
    'action' => '',
    'label' => '',
    'labelCss' => '',
    'allowLabel' => false,
    'phoneCode' => '',
    'phoneCodes' => [],
    'phoneNumber' => '',
    'currentPhoneNumber',
    'currentPhoneCode',
])


<div>
    <ul>
   @foreach ($errors->all() as $error)
       <li>{{ $error }}</li>
   @endforeach
</ul>

    @if (!empty($label))
    <label for="phoneCode" class="input-label {{$labelCss}}">{{$label}}</label>
    @endif
    <div class="phone-code-input-wrapper">
        <select class="phone-code-input" id="phoneCode" name="{{$phoneCode}}" required>

            @foreach ($phoneCodes as $key => $option)
            <option @selected($option['code'] == $currentPhoneCode) value="{{$option['code']}}">{{$option['code']}}</option>
            @endforeach
        </select>

        <input class="phone-number-input @error($phoneNumber) 'inline-error' @enderror"
            name="{{$phoneNumber}}"
            id="phoneNumber"
            value="{{$currentPhoneNumber}}"
            required
        />
    </div>
</div>
