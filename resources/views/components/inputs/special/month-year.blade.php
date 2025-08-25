@props([
    'type' => 'text',
    'id' => '$id',
    'label' => '$label',
    'labelCss' => 'inherit-bg',
    'wrapperCss' => '',
    'inputCss' => '',
    'name' => '',
    'state' => '',
    'xClick' => '',
])

<div x-data="{
        dateValue: '',
        initialize(){
            if(!this.dateValue){
                const today = new Date();
                this.dateValue = today.toISOString().substring(0,7)
                $refs.dateInput = this.dateValue
                console.log(today, this.dateValue)
            }
        },
        formatDate(){
            let useValue = document.getElementById('monthYear').value;
            let date = new Date(useValue);

            let month = ('0' + (date.getMonth() + 1)).slice(-2);
            let year = date.getFullYear();

            this.dateValue = `${year}-${month}`;
        }
    }" x-init="initialize()">


    <p class="month-year-input-description" x-text=" 'Month: ' +dateValue"></p>
    <div class="special-input-wrapper {{$wrapperCss}}">
        <label for="{{$id}}" class="special-input-label {{$labelCss}}">{{$label}}</label>

        <input class="special-input {{$inputCss}}" {!! $attributes->merge() !!}
            type="date"
            name="{{$name}}"
            id="monthYear"
            wire:model{{$state}}="{{$name}}"
            x-on:click="{{$xClick}}"
            x-on:change="formatDate"
            placeholder="yyyy-mm"
        />

        @error($name)
            <span class="error">{{$message}}</span>
        @enderror
    </div>
</div>

