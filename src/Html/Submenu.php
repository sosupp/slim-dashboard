<?php
namespace Sosupp\SlimDashboard\Html;

class Submenu
{
    protected static $subNavs = [];

    public static function menu(
        string $name = '',
        string $url = null,
        string $key = '',
        bool $isCurrent = false,
    )
    {
        static::$subNavs[$name]['name'] = $name;
        static::$subNavs[$name]['url'] = $url;
        static::$subNavs[$name]['key'] = $key;
        static::$subNavs[$name]['isCurrent'] = $isCurrent;

        return new static;
    }

    public function make()
    {
        return static::$subNavs;
    }
}
