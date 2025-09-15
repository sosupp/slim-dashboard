<?php
namespace Sosupp\SlimDashboard\Html\Tables;

use Illuminate\Support\Collection;
use Livewire\Component;

class DynamicTable extends Component
{
    /** @var array<int, array{key:string,label:string,editable?:bool}> */
    public array $columns = [];

    /** @var array<int, mixed>|Collection */
    public $rows = [];

    public string|null $tableCss = null;
    public string|null $theadCss = null;
    public string|null $tbodyCss = null;
    public string|null $rowHeadingCss = null;

    public static function make()
    {
        return new static;
    }

    public function withColumns(array $cols)
    {
        $this->columns = $cols;
        return $this;
    }

    public function withRows(array|Collection $rows)
    {
        $this->rows = $rows;
        return $this;
    }

    // Optional: if you want to persist single-cell edits
    public function saveCell($rowKey, $columnKey)
    {
        $value = data_get($this->rows[$rowKey], $columnKey);

        // Do your save logic here (e.g. DB update)
        // Example if $rows contains Eloquent models:
        // $model = $this->rows[$rowKey];
        // $model->{$columnKey} = $value;
        // $model->save();

        // $this->dispatch('cell-saved', [
        //     'row' => $rowKey,
        //     'column' => $columnKey,
        //     'value' => $value,
        // ]);
    }

    public function render()
    {
        // dd($this->attributes);
        // dd($this->columns);
        return view('slim-dashboard::html.dynamic-table', [
            'columns' => $this->columns,
            'rows' => $this->rows,
        ]);
    }
}
