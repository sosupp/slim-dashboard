<?php

namespace Sosupp\SlimDashboard\View\Components\Dashboard;

use App\View\Components\Slimer\Menus;
use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Navigations extends Component
{
    public $navItems = [];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->navItems = $this->decideNavigationChannel();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // dd("ss");
        return view('slim-dashboard::components.dashboard.navigations');
    }

    protected function decideNavigationChannel()
    {
        // $providedNavClass = config('slim-dashboard.dashboard_navigation');
        if(config('slim-dashboard.dashboard_navigation') !== null){
            return config('slim-dashboard.dashboard_navigation');
        }

        // dd(Menus::items());
        return Menus::items();
    }
}
