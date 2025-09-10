<div
    x-data="{
        isOpen: false,
        selectedOptions: $wire.entangle('{{$name}}'),
        options: @js($options),
        search: '',
        toggle() {
            this.isOpen = !this.isOpen;
        },
        close() {
        this.isOpen = false;
        },
        toggleOption(option) {
            console.log(option)
            this.selectedOptions = this.selectedOptions || [];

            if (this.isSelected(option)) {
                // Remove from selectedOptions
                this.selectedOptions = this.selectedOptions.filter(
                    selected => selected.value !== option.value
                );
            } else {
                // Add to selectedOptions
                this.selectedOptions = [...this.selectedOptions, option];
            }
        },
        isSelected(option) {
            return (this.selectedOptions || []).some(selected => selected.value === option.value);
        },
        get filteredOptions() {
            return this.options.filter(option =>
                option.label.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        get selectedOptionsDetails() {
            return this.options.filter(o => this.selectedOptions.includes(o.value));
            return this.options.filter(option =>
                this.isSelected(option)
            );
        }
    }"
    class="relative w-64">
    <div class="{{$wrapperCss}}">
        <label for="{{$id}}" class="{{$labelCss}}">{{$label}}</label>
        <!-- Selected Options -->
        <div class="multi-search-select-wrapper {{$inputCss}}" :class="isOpen ? 'reset-input-for-select-search' : ''">
            <div class="multi-select-wrapper">
                <template x-for="option in selectedOptions" :key="option.value">
                    <div class="selected-search-item-cta">
                        <span class="as-pointer search-item-cta"
                    x-on:click="toggleOption(option)">&times;</span>
                        <span
                            class="selected-search-item"
                            x-text="option.label"
                        ></span>
                    </div>
                </template>
            </div>

            <!-- Search Input -->
            <input x-on:click="toggle"
                type="text"
                x-model="search"
                placeholder="Search..."
                class="search-select-input"
            />
        </div>

        <!-- Dropdown -->
        <div class="select-search-dropdown" x-cloak x-show="isOpen" @click.away="close">
            <ul class="">
                <template x-for="option in filteredOptions" :key="option.value">
                    <li
                        x-on:click="toggleOption(option)"
                        class="cursor-pointer py-2 px-4 hover:bg-indigo-600 hover:text-white flex items-center"
                    >
                        <input
                            type="checkbox"
                            class="mr-2"
                            :checked="isSelected(option)"
                        >
                        <span x-text="option.label"></span>
                    </li>
                </template>
            </ul>
        </div>
    </div>
</div>
