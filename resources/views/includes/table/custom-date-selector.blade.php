<div>
    <p class="custom-input-label">Start Date</p>
    <input type="date" class="custom-date-input" wire:model="selectedStartDate">
    <p class="custom-input-label">End Date</p>
    <input type="date" class="custom-date-input" wire:model="selectedEndDate">

    <button class="standard-btn" wire:click="selectedDateRange">confirm</button>
</div>
