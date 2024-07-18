<?php
namespace Sosupp\SlimDashboard\Html;

use Illuminate\Contracts\View\View;

class MenuNav
{
    protected static $navs = [];
    protected static $subNavs = [];

    public static function menu(
        string $name = '',
        string $url = null,
        string $key = '',
        bool $isCurrent = false,
        $subMenus = [],
        string $subMenuCss = '',
        bool $authorize = true,
        string|View $icon = null,
        bool $asButton = false,
    )
    {
        static::$navs[$name]['name'] = $name;
        static::$navs[$name]['url'] = $url;
        static::$navs[$name]['key'] = $key;
        static::$navs[$name]['isCurrent'] = $isCurrent;
        static::$navs[$name]['subMenus'] = $subMenus;
        static::$navs[$name]['subMenuCss'] = $subMenuCss;
        static::$navs[$name]['authorize'] = $authorize;
        static::$navs[$name]['icon'] = $icon;
        static::$navs[$name]['asButton'] = $asButton;

        return new static;
    }

    public function make()
    {
        return static::$navs;
    }
}