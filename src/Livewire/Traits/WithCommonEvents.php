<?php
namespace Sosupp\SlimDashboard\Livewire\Traits;

trait WithCommonEvents
{
    public function closePanel()
    {
        $this->dispatch('opensidepanel');
    }
}
