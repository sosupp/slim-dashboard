<?php
namespace Sosupp\SlimDashboard\Html;

class Tabs
{
    public static $tabHeadings = [];
    public static $tabContents = [];
    public static $externalView = [];

    public static function content(
        string $heading,
        string $component = '',
        ?string $route = '',
        string $key,
        $view = null,
        bool $isVisible = true,
        string $headingCss = '',
        string $activeCss = '',
        bool $useNavigate = false
    ): static
    {
        static::$tabContents[$heading]['heading'] = $heading;
        static::$tabContents[$heading]['component'] = $component;
        static::$tabContents[$heading]['url'] = $route;
        static::$tabContents[$heading]['key'] = $key;
        static::$tabContents[$heading]['view'] = $view;
        static::$tabContents[$heading]['isVisible'] = $isVisible;
        static::$tabContents[$heading]['headingCss'] = $headingCss;
        static::$tabContents[$heading]['activeCss'] = $activeCss;
        static::$tabContents[$heading]['useNavigate'] = $useNavigate;

        return new static;
    }

    public function make()
    {
        return static::$tabContents;
    }
}
