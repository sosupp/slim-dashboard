<?php
namespace Sosupp\SlimDashboard\Concerns\Filters;

use Livewire\Attributes\Session;
use Illuminate\Support\Collection;

trait WithDateFilters
{
    #[Session(key: 'selected_date')]
    public $selectedDate = 'today';

    #[Session(key: 'selected_date_label')]
    public $dateLabel = 'today';

    #[Session(key: 'mobile_date_label')]
    public $mobileDateLabel = 'today';

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
        $this->dateLabel = $key;
        $this->mobileDateLabel = $key;
    }

    public function selectedDateRange()
    {
        $this->selectedDate = [
            'start' => $this->selectedStartDate ,
            'end' => $this->selectedEndDate
        ];

        // $this->dateLabel = 'custom date';
        $this->mobileDateLabel = $this->setDateLabel();
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

    public function setDateLabel()
    {
        return euroDate($this->selectedStartDate, false) .' <b>to</b> '.
            euroDate($this->selectedEndDate, false) .'<br />';
    }

}
