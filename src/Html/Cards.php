<?php
namespace Sosupp\SlimDashboard\Html;

class Cards
{
    protected static $cards = [];

    public static function item(
        ?string $label = null,
        string $value = '',
        string $id = '',
        bool $canView = true,
        string $css = '',
        string $subLabel = '',

    ): static
    {
        static::$cards[$label]['label'] = $label;
        static::$cards[$label]['value'] = $value;
        static::$cards[$label]['id'] = $id;
        static::$cards[$label]['canView'] = $canView;
        static::$cards[$label]['css'] = $css;
        static::$cards[$label]['subLabel'] = $subLabel;

        return new static;
    }

    public static function description(string $text = '')
    {
        static::$cards['description'] = $text;
        return new static;
    }

    public function make()
    {
        return static::$cards;
    }
}
