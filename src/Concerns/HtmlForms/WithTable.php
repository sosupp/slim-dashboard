<?php
namespace Sosupp\SlimDashboard\Concerns\HtmlForms;

use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Concerns\UploadImages;
use App\Concerns\Breadcrumbable;
use Livewire\Attributes\Session;
use App\Concerns\AddsSessionData;
use App\Concerns\ModelDeleteable;
use Livewire\Attributes\Computed;
use Livewire\WithoutUrlPagination;

trait WithTable
{
    use AddsSessionData,
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
    public $searchState = '.live';

    public $currentPage = 'test page';

    public $allowSearch = true;

    public $callback;

    public $modelImageId;

    public $hasSidePanel = false;

    #[Session()]
    public $recordPerPage = 20;

    public $subnav = '';

    public $checkRecords = [];
    public $selectAll = false;

    public $withBreadcrumb = true;



    public abstract function useCustomTable();
    public abstract function mount();
    public abstract function tableCols();
    public abstract function tableRecords();
    public abstract function tableActions();
    // public abstract function tableForm();
    public abstract function pageCta();
    public abstract function defineSearch();

    public function relation($model, $relation, $col, $callback = null)
    {
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

    public function configureCustomRelation($model, $relation, $col)
    {
        $testMethod = $this->callback;
        return $this->$testMethod($model);
    }

    public function configureFilterColumns(string $relation, array $cols)
    {
        // dd(collect($cols)->implode(','));
        // dd($cols);
        $model = 'App\Models\\'.Str::ucfirst($relation);
        return $model::query()->pluck(...$cols);
        // dd($model::query()->pluck(...$cols));
    }

    public function tableForm(){}

    public function setLinks()
    {
        $this->editLink = '';
    }

    public function panelWidth()
    {
        return 'inherit';
    }

    public function updatedInlineImages()
    {
        $image = $this->uploadInlineImage(data: ['image' => $this->inlineImages[$this->modelImageId][0]] );
        $updatedImage = $this->updateImageColumn($this->modelImageId, $image);

        if($updatedImage){
            session()->flash('inline-upload-success'.$this->modelImageId);
        }
    }

    public function showPagination()
    {
        return false;
    }

    public function showStandardTable()
    {
        return true;
    }

    public function showTableToCards()
    {
        return true;
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

}
