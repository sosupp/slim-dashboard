<?php
namespace Sosupp\SlimDashboard\Html;

class PageCtas
{
    protected static $pageActions = [];

    public static function cta(
        string $type = 'link',
        string $label,
        string|null $route = null,
        string|null $wireAction = null,
        string|null $wireProperty = null,
        string $css = '',
        bool $withSidePanel = false,
        bool $shouldConfirm = true,
        string $confirmMessage = '',
        string $wireTarget = 'selectAll',
        ?string $component = null,
        bool $show = true,
        array|null $options = [],
        string $optionKey = 'name',
        string $optionId = 'id',
    )
    {
        static::$pageActions[$label]['type'] = $type;
        static::$pageActions[$label]['label'] = $label;
        static::$pageActions[$label]['route'] = $route;
        static::$pageActions[$label]['wireAction'] = $wireAction;
        static::$pageActions[$label]['wireProperty'] = $wireProperty;
        static::$pageActions[$label]['css'] = $css;
        static::$pageActions[$label]['withSidePanel'] = $withSidePanel;
        static::$pageActions[$label]['shouldConfirm'] = $shouldConfirm;
        static::$pageActions[$label]['confirmMessage'] = $confirmMessage;
        static::$pageActions[$label]['wireTarget'] = $wireTarget;
        static::$pageActions[$label]['component'] = $component;
        static::$pageActions[$label]['show'] = $show;
        static::$pageActions[$label]['options'] = $options;
        static::$pageActions[$label]['optionKey'] = $optionKey;
        static::$pageActions[$label]['optionId'] = $optionId;

        return new static;
    }

    public static function ctaDropdown(
        string $type = 'dropdown',
        string $label = '',
        string $key = '',
        string $id = '',
        array|null $options = [],
        string $optionKey = 'name',
        string $optionId = 'id',
        ?string $wireProperty = '',
        ?string $wireAction = '',
        string $css = '',
        bool $show = true,

    )
    {
        static::$pageActions[$label]['type'] = $type;
        static::$pageActions[$label]['label'] = $label;
        static::$pageActions[$label]['key'] = $key;
        static::$pageActions[$label]['id'] = $id;
        static::$pageActions[$label]['options'] = $options;
        static::$pageActions[$label]['optionKey'] = $optionKey;
        static::$pageActions[$label]['optionId'] = $optionId;
        static::$pageActions[$label]['wireProperty'] = $wireProperty;
        static::$pageActions[$label]['wireAction'] = $wireAction;
        static::$pageActions[$label]['css'] = $css;
        static::$pageActions[$label]['show'] = $show;
        return new static;
    }

    public function make()
    {
        return static::$pageActions;
    }
}
