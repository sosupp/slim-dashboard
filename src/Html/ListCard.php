<?php
namespace Sosupp\SlimDashboard\Html;

class ListCard
{
    public $cardContents = [];

    public static function content(
    )
    {
        return new static;
    }

    public function row(
        string $name,
        string|null $label = null,
        string $key,
        string $relation = null,
        $callback = null,
        string $css = '',
        string $labelCss = '',
        string $valueCss = '',
        bool $canView = true

    ){

        $this->cardContents[] = compact(
            'name',
            'label',
            'key',
            'relation',
            'callback',
            'css',
            'labelCss',
            'valueCss',
            'canView'
        );
        return $this;
    }

    public function make()
    {
        return collect($this->cardContents)->groupBy('key')->toArray();
    }
}
