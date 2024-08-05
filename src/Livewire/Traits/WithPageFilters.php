<?php
namespace Sosupp\SlimDashboard\Livewire\Traits;

trait WithPageFilters
{
    public function pageFilters()
    {
        return [];
    }

    public function includePageFilters()
    {
        return 'slim-dashboard::includes.table.table-filters';
    }
}
