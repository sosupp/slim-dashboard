<?php

namespace Sosupp\SlimDashboard;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sosupp\SlimDashboard\Skeleton\SkeletonClass
 */
class SlimDashboardFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'slim-dashboard';
    }
}
