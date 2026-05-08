<?php

namespace Sosupp\SlimDashboard\Livewire\Traits;

trait HasDesktop
{

    public function mountHasDesktop()
    {
        if(config('slimerdesktop.enabled')){
            $this->withDesktop = true;
        }
    }

    abstract function callRemoteTable();

}
