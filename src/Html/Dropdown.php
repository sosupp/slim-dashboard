<?php
namespace Sosupp\SlimDashboard\Html;

class Dropdown
{
    protected static $items = [];

    public static function item(
        ?string $key = null,
        ?string $id = '',
        string $name = 'name',
        string $label,

    ): static
    {
        static::$items[$label]['key'] = $key;
        static::$items[$label]['id'] = $id;
        static::$items[$label]['name'] = $name;
        static::$items[$label]['label'] = $label;

        return new static;
    }

    public function make()
    {
        return static::$items;
    }

}
