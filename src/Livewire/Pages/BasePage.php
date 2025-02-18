<?php
namespace Sosupp\SlimDashboard\Livewire\Pages;

use Livewire\Component;
use Sosupp\SlimDashboard\Concerns\Html\WithBreadcrumb;
use Sosupp\SlimDashboard\Livewire\Traits\HandleUserAlerts;

abstract class BasePage extends Component
{
    use WithBreadcrumb,
        HandleUserAlerts;

    public $pageTitle;

    abstract function breadcrumbData();

    public function includePageFilters()
    {
        return '';
    }

    // public function render()
    // {
    //     return view('livewire.base-page')
    //     ->layoutData(['breadcrumb' => $this->breadcrumbData()])
    //     ->title($this->pageTitle);;
    // }
}