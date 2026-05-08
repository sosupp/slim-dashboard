<?php

namespace Sosupp\SlimDashboard\Livewire\Tables;

use Livewire\Attributes\Reactive;
use Illuminate\Contracts\View\View;
use Sosupp\SlimDashboard\Livewire\Tables\BaseTable;
use Sosupp\SlimDashboard\Concerns\Filters\WithDateFilters;
use Sosupp\SlimDashboard\Livewire\Traits\HandlesFileExport;
use Sosupp\SlimDashboard\Concerns\Filters\WithPresentableDateFormat;


abstract class ReportsTable extends BaseTable
{
    use WithDateFilters,
        WithPresentableDateFormat,
        HandlesFileExport;

    #[Reactive]
    public $selectedDate = 'today';

    #[Reactive]
    public $selectedBranch;

    abstract function reportHeading();

    public function tableHeading()
    {
        return $this->reportHeading();
    }

    public function useCustomTable() { }

    public function tableActions() { }

    public function defineSearch() { }

    public function mount()
    {
        $this->allowSearch = false;
        $this->withCheckbox = false;
        $this->hasActions = false;
        $this->recordPerPage = 50;

        $this->useMount();

    }

    public function useMount()
    {

    }

    public function showPagination()
    {
        return true;
    }

    public function hasCustomDatePanel()
    {
        return true;
    }

    public function pdfTableCols(): array
    {
        return [];
    }

    public function pdfTableRows(): array
    {
        return [];
    }

    public function pdfView(): string|View
    {
        return view('slim-dashboard::livewire.reports.pdf.report-base-table', [
            'columns' => empty($this->pdfTableCols()) ? $this->tableCols() : $this->pdfTableCols(),
            'rows' => empty($this->pdfTableRows()) ? $this->tableRecords : $this->pdfTableRows(),
            'reportHeading' => $this->reportHeading()
        ]);
    }
}
