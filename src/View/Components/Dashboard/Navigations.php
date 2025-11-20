<?php

namespace Sosupp\SlimDashboard\View\Components\Dashboard;

use App\View\Components\Slimer\Menus\Menus;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Closure;

class Navigations extends Component
{
    public array $navItems;

    /**
     * Create a new component instance.
     */
    public function __construct(
        array $data = []
    ) {
        $this->navItems = !empty($data)
            ? $data
            : $this->decideNavigationChannel();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('slim-dashboard::components.dashboard.navigations');
    }

    /**
     * Determine where to retrieve the navigation items.
     */
    protected function decideNavigationChannel(): array
    {
        $configNavigation = config('slim-dashboard.dashboard_navigation');

        if (is_array($configNavigation) && !empty($configNavigation)) {
            return $configNavigation;
        }

        return Menus::items();
    }
}
