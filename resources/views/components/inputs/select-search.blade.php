<div x-data="{
        isOpen: false,
        search: '',
        selected: $wire.entangle('{{$name}}'),
        options: @js($options),
        toggle() {
        this.isOpen = !this.isOpen;
        },
        close() {
        this.isOpen = false;
        },
        select(value) {
        this.selected = value;
        this.search = '';
        this.close();
        },
        get filteredOptions() {
            return this.options.filter(option =>
                option.label.toLowerCase().includes(this.search.toLowerCase())
            );
        },
    }" class="">

    <!-- Dropdown -->
    <div class="{{$wrapperCss}}">
        <label for="{{$id}}" class="{{$labelCss}}">{{$label}}</label>
        <div class="search-and-select-wrapper {{$inputCss}}"
            :class="isOpen ? 'reset-input-for-select-search' : ''">

            <div x-cloak x-show="selected" class="selected-search-item-cta">
                <span class="as-pointer search-item-cta"
                    x-on:click="selected=null">&times;</span>
                <span class="selected-search-item" x-text="selected ? options.find(option => option.value === selected).label : ''"></span>
            </div>

            <input
                x-on:click="toggle"
                type="text"
                placeholder="Search..."
                x-model="search"
                class="search-select-input"
            />
        </div>

        <div x-show="isOpen" @click.away="close"
            class="select-search-dropdown">
            <!-- Options -->
            <template x-for="option in filteredOptions" :key="option.value">
                <div x-on:click="select(option.value)"
                    class="search-dropdown-items"
                    :class="{ '': option.value === selected }"
                >
                    <span class="as-pointer search-select-item" x-text="option.label"></span>
                </div>
            </template>
        </div>
    </div>
</div>
