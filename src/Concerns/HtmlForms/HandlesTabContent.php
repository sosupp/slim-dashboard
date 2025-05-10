<?php
namespace Sosupp\SlimDashboard\Concerns\HtmlForms;

trait HandlesTabContent
{
    public $selectedTab = 'details';
    public $selectedWire = '';
    public $selectedExternalView = '';
    public $asWireTab = false;

    public function changeTab($tab)
    {
        $this->selectedTab = $tab;
    }

    public function switchWire($component, $view)
    {

        $this->selectedWire = $component;
        $this->selectedExternalView = $view;
        $this->asWireTab = true;
    }
}
