<?php

namespace Sosupp\SlimDashboard\Livewire\Tables;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Attributes\Lazy;
use Livewire\WithFileUploads;
use Livewire\Attributes\Session;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use Livewire\WithoutUrlPagination;
use Sosupp\SlimDashboard\Concerns\UploadImages;
use Sosupp\SlimDashboard\Concerns\AddsSessionData;
use Sosupp\SlimDashboard\Concerns\ModelDeleteable;
use Sosupp\SlimDashboard\Concerns\Html\WithDefaultCss;
use Sosupp\SlimDashboard\Concerns\HtmlForms\WithTableFilters;

#[Lazy(isolate: false)]
abstract class BaseTable extends Component
{
    use WithDefaultCss,
        AddsSessionData,
        ModelDeleteable,
        WithTableFilters,
        WithFileUploads,
        WithPagination,
        WithoutUrlPagination,
        UploadImages;

    public $pageHeading;
    public $pageTitle;
    public $tableCols = [];
    public $editLink;

    public $search = '';
    public $searchPlaceholder = 'Search table';
    public $searchState = '.blur';

    public $hasSearchResultDropdown = false;
    public $searchResultDropdownView = null;

    public $currentPage = 'test page';

    public $allowSearch = true;

    public $callback;

    public $modelImageId;
    public $selectedImageName;

    public $hasSidePanel = false;

    #[Session()]
    public $recordPerPage = 10;

    public $subnav = '';

    public $checkRecords = [];
    public $selectAll = false;
    public $withCheckbox = true;
    public $hasActions = true;

    public $withBreadcrumb = true;



    public abstract function mount();
    public abstract function useCustomTable();
    public abstract function tableCols();
    public abstract function tableRecords();
    public abstract function tableActions();
    // public abstract function tableForm();
    public abstract function pageCta();
    public abstract function defineSearch();

    public function pageFilters()
    {
        return [];
    }

    public function relation($model, $relation, $col, $callback = null)
    {
        // dd($callback);
        $this->callback = $callback;

        // Use this to handle relations that are not one-to-one
        if($relation === 'custom'){
            // dd($relation);
            return $this->configureCustomRelation($model, $relation, $col);
        }

        // dd($relation);
        // $this->valuesForFilterColumn[] = $model->$relation->pluck('id')->all();
        // dd($this->valuesForFilterColumn);
        return $model->$relation->$col ?? ''; // Gets one-to-one relation
    }

    public function useModel(){}
    public function getOneModel(string|int $id){}
    public function updateImageColumn(string|int $modelId, string $image){}
    public function breadcrumbData(){}
    public function setCustomRoute($model){}
    public function useSideModal(){}
    public function panelCustomView(){}

    public function searchModelResults(): array|Collection
    {
        return [];
    }

    #[Computed()]
    public function inlineTableStatistics(): array|Collection
    {
        return [];
    }

    #[Computed()]
    public function showInlineTableStatistics(): bool
    {
        return false;
    }

    public function cardsWrapperCss()
    {
        return 'table-inline-stats-summary';
    }


    public function configureCustomRelation($model, $relation, $col)
    {
        $testMethod = $this->callback;
        return $this->$testMethod($model);
    }

    public function configureFilterColumns($relation = '', array $cols, string $filterModel = '', bool $hasCustomColKeys)
    {
        if(empty($cols)){
            return [];
        }

        if($hasCustomColKeys){
            return $cols;
            $this->customFilterLogic($relation, $cols, $filterModel, $hasCustomColKeys);
            return;
        }

        $model = '';

        if($relation !== 'custom'){
            $model = 'App\Models\\'.Str::ucfirst($relation);
            // dd($relation, $cols, $filterModel);
        }

        if(!empty($filterModel) && $relation === 'custom'){
            $model = 'App\Models\\'.Str::ucfirst($filterModel);
            // dd($filterModel);
        }

        // dd($model);
        return $model::query()->pluck(...$cols);
        // dd($model::query()->pluck(...$cols));
    }

    public function customFilterLogic($relation, $cols, $filterModel, $hasCustomColKeys)
    {
        $callback = $hasCustomColKeys;
        return $this->$callback($relation, $cols, $filterModel);
    }

    public function tableForm(){}

    public function setLinks()
    {
        $this->editLink = '';
    }

    public function updatedInlineImages()
    {
        // dd($this->inlineImagesNames, $this->inlineImages, $this->selectedImageName);
        $image = $this->uploadInlineImage(
            data: [
                'image' => $this->inlineImages[$this->modelImageId][0],
                'filename' => $this->selectedImageName
            ]
        );

        $updatedImage = $this->updateImageColumn($this->modelImageId, $image);

        if($updatedImage){
            session()->flash('inline-upload-success'.$this->modelImageId);
        }
    }

    public function showPagination()
    {
        return false;
    }

    public function showPaginationFilter()
    {
        return true;
    }

    public function showStandardTable()
    {
        return true;
    }

    public function showTableToCards()
    {
        return false;
    }

    public function compositePage()
    {
        return '';
    }

    public function tableHeading()
    {
        return '';
    }

    #[Computed()]
    public function pageSideData()
    {
        return '';
    }

    #[Computed()]
    public function pageSubNavs()
    {
        return [];
    }

    public function subActiveView()
    {
        return '';
    }

    public function wireConfirm(string $message)
    {
        return 'wire:confirm' . '=' ."continue?";
    }

    public function hasCustomDatePanel()
    {
        return false;
    }



    public function render()
    {
        // dd($this->breadcrumbData());
        // dd('yes');
        return view('slim-dashboard::livewire.tables.base-table')
        ->layoutData(['breadcrumb' => $this->breadcrumbData()])
        ->title($this->pageTitle);
    }
}
