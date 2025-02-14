<div class="table-search">
    @if ($this->allowSearch)
        <x-inputs.livewire.text type="search" id="tableSearch"
            label="Search table"
            name="search"
            state=".live.debounce.250ms" class="custom-input-wrapper"
            placeholder="{{$this->searchPlaceholder}}"
            xClick="openResults=!openResults;searchFilters=true"
        />
    @endif
</div>
