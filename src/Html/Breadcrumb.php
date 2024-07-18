<?php
namespace Sosupp\SlimDashboard\Html;

class Breadcrumb
{
    protected static $navs = [];

    public static function nav(string $name = '', string $url = null, bool $isBase = false, bool $isCurrent = false)
    {
        static::$navs[$name]['name'] = $name;
        static::$navs[$name]['url'] = $url;
        static::$navs[$name]['isBase'] = $isBase;
        static::$navs[$name]['isCurrent'] = $isCurrent;

        return new static;
    }

    public function make()
    {
        return static::$navs;
    }
}
