<?php
namespace Sosupp\SlimDashboard\Html;

class PageFilter
{
    protected static $filters = [];

    public static function filter(
        string $type = 'select',
        string $label = '',
        string $key = '',
        string $id = '',
        array|null $options = [],
        string $optionKey = 'name',
        string $optionId = 'id',
        ?string $wireProperty = '',
        ?string $wireAction = '',
        bool $showFilter = true,
        string $wrapperCss = '',
    ){
        static::$filters[$label]['type'] = $type;
        static::$filters[$label]['label'] = $label;
        static::$filters[$label]['key'] = $key;
        static::$filters[$label]['id'] = $id;
        static::$filters[$label]['options'] = $options;
        static::$filters[$label]['optionKey'] = $optionKey;
        static::$filters[$label]['optionId'] = $optionId;
        static::$filters[$label]['wireProperty'] = $wireProperty;
        static::$filters[$label]['wireAction'] = $wireAction;
        static::$filters[$label]['showFilter'] = $showFilter;
        static::$filters[$label]['wrapperCss'] = $wrapperCss;

        return new static;
    }


    public function make()
    {
        return static::$filters;
    }

}

