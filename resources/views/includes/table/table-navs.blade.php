<div class="filter-and-nav">
    <select wire:model.live="recordPerPage" id="recordPerPage" class="select-filter" :class="darkmode ? 'dmode-input-bg' : ''">
        <option value="10">Show: 10</option>
        <option value="20">Show: 20</option>
        <option value="30">Show: 30</option>
        <option value="50">Show: 50</option>
        <option value="100">Show: 100</option>
    </select>

    @if (count($this->tableRecords) > 0)
    {{-- <div class="custom-pagination">
    </div> --}}
    {{$this->tableRecords->links()}}
    @endif
</div>
