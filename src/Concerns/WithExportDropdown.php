<?php
namespace Sosupp\SlimDashboard\Concerns;

use Sosupp\SlimDashboard\Html\Dropdown;

trait WithExportDropdown
{
    public $selectedExportType;

    abstract function handleExport(string|null $value);

    public function exportDropdown()
    {
        return Dropdown::item(key: '', id: '', name: 'pdf', label: 'PDF')
        ->item(key: '', id: '', name: 'excel', label: 'excel')
        ->make();
    }

    public function getExportType()
    {
        if(is_null($this->selectedExportType) || empty($this->selectedExportType) || str()->lower($this->selectedExportType) == 'export'){
            return;
        }

        // dd($this->selectedExportType);
        $type = $this->selectedExportType;
        $this->reset('selectedExportType');

        return str()->lower($type);
    }

    public function composeFilename(string $name, string $extension)
    {
        return $name .'_' .now()->format('y-m-d-m-s').'.'.$extension;
    }

    public function updatedSelectedExportType($value)
    {
        $this->handleExport($this->getExportType());
    }

}
