<?php

namespace Sosupp\SlimDashboard\Livewire\Pages;

use Sosupp\SlimDashboard\Concerns\Filters\WithDateFilters;
use Sosupp\SlimDashboard\Concerns\HasModalPanel;

class BaseReportGeneratorPage extends BasePage
{
    use HasModalPanel, WithDateFilters;

    public $reportModel;

    public $componentName;

    public function sidePanelModel($id)
    {
        throw new \Exception('Not implemented');
    }
    
    public function breadcrumbData()
    {
        throw new \Exception('Not implemented');
    }

    public function render()
    {
        return view('slim-dashboard::livewire.pages.base-report-generator-page');
    }

}