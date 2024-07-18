<?php
namespace Sosupp\SlimDashboard\Concerns\Tables;

trait HasCustomPanelView
{

    public $sidePanelComponent = '';

    public function panelCustomView()
    {
        if(!empty($this->sidePanelComponent)){
            if(is_string($this->sidePanelComponent)){
                $view = $this->sidePanelComponent;
                return $this->$view();
            }
        }
    }
}
