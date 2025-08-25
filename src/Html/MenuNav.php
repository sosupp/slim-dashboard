<?php
namespace Sosupp\SlimDashboard\Html;

use Illuminate\Contracts\View\View;

class MenuNav
{
    protected static $navs = [];
    protected static $subNavs = [];

    public static function menu(
        string $name = '',
        string|null $url = null,
        string $key = '',
        bool $isCurrent = false,
        $subMenus = [],
        string $subMenuCss = '',
        bool $authorize = true,
        string|View|null $icon = null,
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

    public static function item(
        string $name = '',
        string|null $url = null,
        string $key = '',
        bool $isCurrent = false,
        $subMenus = [],
        string $subMenuCss = '',
        bool $authorize = true,
        string|View|null $icon = null,
        bool $asButton = false,
    )
    {
        static::$navs['menu'][$name]['name'] = $name;
        static::$navs['menu'][$name]['url'] = $url;
        static::$navs['menu'][$name]['key'] = $key;
        static::$navs['menu'][$name]['isCurrent'] = $isCurrent;
        static::$navs['menu'][$name]['subMenus'] = $subMenus;
        static::$navs['menu'][$name]['subMenuCss'] = $subMenuCss;
        static::$navs['menu'][$name]['authorize'] = $authorize;
        static::$navs['menu'][$name]['icon'] = $icon;
        static::$navs['menu'][$name]['asButton'] = $asButton;

        return new static;
    }

    public static function logo(
        string $name = '',
        string $key = '',
        string|View|null $view = '',
        string|null $route = null,
        $image = null,
        bool $authorize = true,
        string $logoWrapper = 'brand-logo-wrapper',
    )
    {
        static::$navs['logo']['name'] = $name;
        static::$navs['logo']['key'] = $key;
        static::$navs['logo']['view'] = $view;
        static::$navs['logo']['route'] = $route;
        static::$navs['logo']['image'] = $image;
        static::$navs['logo']['authorize'] = $authorize;
        static::$navs['logo']['wrapper'] = $logoWrapper;

        return new static;
    }

    public static function logout(
        string $name = 'logout',
        string $key = '',
        string|View|null $view = '',
        string|null $route = null,
    )
    {
        static::$navs['logout']['name'] = $name;
        static::$navs['logout']['key'] = $key;
        static::$navs['logout']['view'] = $view;
        static::$navs['logout']['route'] = $route;

        return new static;
    }

    public static function extraView(
        string $key = '',
        string|View|null $view = '',
        bool $authorize = true,
    )
    {
        static::$navs['extraView']['key'] = $key;
        static::$navs['extraView']['view'] = $view;
        static::$navs['extraView']['authorize'] = $authorize;

        return new static;
    }

    public static function globalActions(
        string $name = '',
        string $key = '',
        string|null $route = null,
        string|View|null $view = null,
        bool $authorize = true,
        bool $asButton = false,
    )
    {
        static::$navs['action'][$key]['name'] = $name;
        static::$navs['action'][$key]['key'] = $key;
        static::$navs['action'][$key]['route'] = $route;
        static::$navs['action'][$key]['view'] = $view;
        static::$navs['action'][$key]['authorize'] = $authorize;
        static::$navs['action'][$key]['asButton'] = $asButton;

        return new static;
    }

    public static function styles(
        string $wrapperCss = 'admin-sidenav',
        string $navsBg = 'light-purple-nav',
    )
    {
        static::$navs['css']['wrapper'] = $wrapperCss;
        static::$navs['css']['bg'] = $navsBg;

        return new static;
    }



    public function make()
    {
        return static::$navs;
    }
}
