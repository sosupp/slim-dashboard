@props([
    'id' => '$id',
    'name' => '',
    'action' => '',
    'option' => '',
    'optionId' => '',
    'optionKey' => '',
    'options' => [],
    'label' => '$label',
    'class' => '',
    'allowLabel' => false,
])

<div class="{{$class}}" x-data>
    {{-- @if ($allowLabel)
    <label for="{{$id}}">{{$label}}</label>
    @endif

    <select x-cloak class="custom-form-control"
        id="{{$id}}"
        wire:model.live="{{$name}}"
        wire:key="{{$id}}_{{$label}}_{{$name}}"
        {{$action}}>

        <option value="{{$optionId ?? $option}}">{{$option == '' ? $label : $option}}</option>

        @foreach ($options as $opt)
        <option value="{{$opt->id ?? $opt[$optionId] ?? $opt}}">{{$opt->$optionKey ?? $opt[$optionKey] ?? $opt}}</option>
        @endforeach
    </select>

    @error($name)
        <span class="form-error">{{$message}}</span>
    @enderror --}}

    <div x-data="{
        options: @json($options),
        selected: [],
        show: false,
        open() { this.show = true },
        close() { this.show = false },
        isOpen() { return this.show === true },
        select(index, event) {

            if (!this.options[index].selected) {

                this.options[index].selected = true;
                this.options[index].element = event.target;
                this.selected.push(index);

            } else {
                this.selected.splice(this.selected.lastIndexOf(index), 1);
                this.options[index].selected = false
            }
        },
        remove(index, option) {
            this.options[option].selected = false;
            this.selected.splice(index, 1);


        },
        loadOptions() {
            const options = document.getElementById('select').options;
            for (let i = 0; i < options.length; i++) {
                this.options.push({
                    value: options[i].value,
                    text: options[i].innerText,
                    selected: options[i].getAttribute('selected') != null ? options[i].getAttribute('selected') : false
                });
            }


        },
        selectedValues(){
            return this.selected.map((option)=>{
                return this.options[option].value;
            })
        }
    }" x-init="loadOptions(), console.log(options)">
        <input type="text" name="optionValues" x-bind:value="selectedValues()">
        <div class="inline-block relative w-64">
            <div class="flex items-center-relative">
                <div class="w-full" x-on:click="open">
                    <div class="bg-white rounded">
                        <div class="flex flex-auto flex-wrap">
                            <template x-for="(option, index) in selected" :key="options[option].value">
                                <div>
                                    <div class="loading-more" x-model="options[option]"
                                        x-text="options[option].text"></div>
                                </div>

                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
