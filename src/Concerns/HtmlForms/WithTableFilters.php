<?php
namespace Sosupp\SlimDashboard\Concerns\HtmlForms;

trait WithTableFilters
{
    public $multiSelectFilterKeys = [];
    public $valuesForFilterColumn = [];

    public function applyFilter()
    {
        // dd($this->multiSelectFilterKeys);
    }

    public function clear()
    {
        // dd("yes");
        $this->reset();
        $this->tableRecords;
    }
}
