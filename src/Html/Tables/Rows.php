<?php
namespace Sosupp\SlimDashboard\Html\Tables;

class Rows
{
    protected static $columnActions = [];

    public static function action(
        string $name,
        string $link = '',
        string|null $component = null,
        string|null $customRoute = null,
        bool $sidePanel = false,
        string $panelHeading = '',
        bool $asCheckbox = false,
        string|null $wireAction = null,
        bool $isVisible = true,
        bool $confirm = false,
        bool $isAuthorize = false,
        string $screen = 'all',
    )
    {

        $wire = 'wire' . ':confirm' . '=' . "Are you sure";

        $useConfirm = $confirm ? $wire : '';

        static::$columnActions[$name]['label'] = $name;
        static::$columnActions[$name]['link'] = $link;
        static::$columnActions[$name]['component'] = $component;
        static::$columnActions[$name]['customRoute'] = $customRoute;
        static::$columnActions[$name]['sidePanel'] = $sidePanel;
        static::$columnActions[$name]['panelHeading'] = $panelHeading;
        static::$columnActions[$name]['asCheckbox'] = $asCheckbox;
        static::$columnActions[$name]['wireAction'] = $wireAction;
        static::$columnActions[$name]['isVisible'] = $isVisible;
        static::$columnActions[$name]['confirm'] = $useConfirm;
        static::$columnActions[$name]['isAuthorize'] = $isAuthorize;
        static::$columnActions[$name]['screen'] = $screen;
        return new static;
    }

    public function make()
    {
        return static::$columnActions;
    }

}
