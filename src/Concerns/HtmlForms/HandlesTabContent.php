<?php
namespace Sosupp\SlimDashboard\Concerns\HtmlForms;

trait HandlesTabContent
{
    public $selectedTab = 'details';

    public function changeTab($tab)
    {
        $this->selectedTab = $tab;
    }
}
