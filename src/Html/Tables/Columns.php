<?php
namespace Sosupp\SlimDashboard\Html\Tables;

class Columns
{
    public $columnNames = [];
    public $columnActions = [];

    public static function make()
    {
        return new static;
    }

    public function column(
        string $name,
        string $label = '',
        string $subLabel = '',
        string|null $relation = null,
        $callback = null,
        $type = '',
        $filter = false,
        $filterCols = [],
        bool $hasCustomColKeys = false,
        $wireFilterProperty = null,
        string|null $key = null,
        string $css = '',
        bool $showLabel = false,
        string $filterModel = '',
        bool $inlineEdit = false,
        string $inlineEditMethod = '',
        bool $sidePanel = false,
        string $panelHeading = '',
        string|null $sideView = null,
        string|null $colForImageName = null,
        bool $hasButton = false,
        bool $canView = true,
        string $valueCss = 'many-pills',
        string|null $format = null,
        string $screen = 'all'
    )
    {
        $useLabel = $label == '' ? $name : $label;

        $this->columnNames[$label]['label'] = $useLabel;
        $this->columnNames[$label]['subLabel'] = $subLabel;
        $this->columnNames[$label]['col'] = $name;
        $this->columnNames[$label]['relation'] = $relation;
        $this->columnNames[$label]['callback'] = $callback;
        $this->columnNames[$label]['type'] = $type;
        $this->columnNames[$label]['filter'] = $filter;
        $this->columnNames[$label]['filtercols'] = $filterCols;
        $this->columnNames[$label]['hasCustomColKeys'] = $hasCustomColKeys;
        $this->columnNames[$label]['wireProperty'] = $wireFilterProperty;
        $this->columnNames[$label]['key'] = $key;
        $this->columnNames[$label]['css'] = $css;
        $this->columnNames[$label]['showLabel'] = $showLabel;
        $this->columnNames[$label]['filterModel'] = $filterModel;
        $this->columnNames[$label]['inlineEdit'] = $inlineEdit;
        $this->columnNames[$label]['inlineEditMethod'] = $inlineEditMethod;
        $this->columnNames[$label]['sidePanel'] = $sidePanel;
        $this->columnNames[$label]['panelHeading'] = $panelHeading;
        $this->columnNames[$label]['sideView'] = $sideView;
        $this->columnNames[$label]['colForImageName'] = $colForImageName;
        $this->columnNames[$label]['hasButton'] = $hasButton;
        $this->columnNames[$label]['canView'] = $canView;
        $this->columnNames[$label]['valueCss'] = $valueCss;
        $this->columnNames[$label]['format'] = $format;
        $this->columnNames[$label]['screen'] = $screen;
        return $this;
    }

    public function action(string $name, string $link = '')
    {
        $this->columnActions[$name]['label'] = $name;
        return $this->columnActions;
    }

    public function build()
    {
        // dd($this->columnNames);
        // return array_map(function($item){
        //     return [
        //         'label' => $item
        //     ];
        // }, $this->columnNames);
        return $this->columnNames;

        $headings = [];
        foreach($this->columnNames as $colHeading){
            $headings[] = $colHeading;
        }

        return $headings;
    }

}
