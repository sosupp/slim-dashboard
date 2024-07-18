<?php
namespace Sosupp\SlimDashboard\Concerns\Filters;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

trait WithDateFilters
{
    public $selectedDate = 'today';
    public $selectedStartDate;
    public $selectedEndDate;

    public function hasCustomDatePanel()
    {
        return true;
    }

    public function dateFilterOptions(): Collection
    {
        $options = [
            ['name' => 'today'],
            ['name' => 'yesterday'],
            ['name' => 'this week'],
            ['name' => 'last week'],
            ['name' => 'this month'],
            ['name' => 'last month'],
            ['name' => 'this year'],
            ['name' => 'last year'],
            // ['name' => 'all time'],
            ['name' => 'custom date', 'type' => 'toggler'],
        ];

        return collect($options);
    }

    public function selectedCustomDateFilter($key)
    {
        $this->selectedDate = $key;
    }

    public function selectedDateRange()
    {
        $this->selectedDate = [
            'start' => $this->selectedStartDate ,
            'end' => $this->selectedEndDate
        ];
    }

    public function dateDescription()
    {
        $description = '<b>';


        $description .= is_string($this->selectedDate)
            ? str($this->selectedDate)->upper()
            : (
                !empty($this->selectedDate['end'])
                ? str(collect($this->selectedDate)->implode(' to ', ''))
                : $this->selectedDate['start']
            );

        return $description .= '</b>';
    }

}
