<?php

namespace Sosupp\SlimDashboard\Livewire\Tables;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Attributes\Lazy;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Session;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use Livewire\WithoutUrlPagination;
use Illuminate\Contracts\View\View;
use Sosupp\SlimDashboard\Concerns\UploadImages;
use Sosupp\SlimDashboard\ValueObjects\CardEdit;
use Sosupp\SlimDashboard\Concerns\AddsSessionData;
use Sosupp\SlimDashboard\Concerns\ModelDeleteable;
use Sosupp\SlimDashboard\Concerns\Html\WithDefaultCss;
use Sosupp\SlimDashboard\Concerns\HtmlForms\WithTableFilters;
use Sosupp\SlimDashboard\Livewire\Traits\HandleUserAlerts;

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
        UploadImages,
        HandleUserAlerts;

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
    public $previewImagePath;

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
    public abstract function tableCols();
    public abstract function tableRecords();
    public abstract function tableActions();
    // public abstract function tableForm();
    public abstract function pageCta();
    public abstract function defineSearch();

    public function updatedSelectAll($key)
    {
        if($key===false){
            $this->checkRecords = [];
            return;
        }

        $this->checkRecords = $this->tableRecords->pluck('id')->all();
    }

    public function useCustomTableView(){}
    
    public function pageFilters()
    {
        return [];
    }

    public function formatDate($record, $dateCol = 'created_at')
    {
        return euroDate($record->$dateCol);
    }

    public function customDateFormat(string|null $date)
    {
        if(is_null($date)){
            return;

        }
        return Carbon::parse($date)->format('d M Y, H:i');
    }

    public function relation($model, $relation, $col, $callback = null, $valueCss = '')
    {
        // Use this to handle relations that are not covered
        if($relation === 'custom'){
            $this->callback = $callback;
            // dd($relation);
            return $this->configureCustomRelation($model, $relation, $col);
        }

        // dd($callback, $model->$relation->$col());
        // $this->callback = $callback;
        if($callback){
            return call_user_func($callback, $model);
        }

        // Handles many-to-many relation
        if(str($relation)->contains('.many')){
            $useRelation = str($relation)->before('.many')->value;
            $result = '';
            foreach ($model->{$useRelation} as $key => $value) {
                $result .="<p class='$valueCss'>{$value->$col}</p>";
            }
            return $result;
        }

        // We want to call a method/accessor on distance(nested) relation
        if(str($col)->startsWith('.') && str($relation)->contains('.')){
            $distanceRelation = str($relation)->after('.')->value;
            $firstRelation = str($relation)->before('.')->value;
            $method = str($col)->after('.')->value;

            // dd("yes", $distanceRelation->value);
            return $model->$firstRelation->$distanceRelation->$method();
        }

        // if true we want to call a method or accessor on the relation
        if(str($col)->startsWith('.')){
            $method = str($col)->after('.')->value;
            return $model->$relation->$method();
        }

        // Here, we want to return the value on a distant(nested) relation
        if(str($relation)->contains('.')){
            $distanceRelation = str($relation)->after('.')->value;
            $firstRelation = str($relation)->before('.')->value;
            // dd("yes", $distanceRelation);
            // return '';
            return $model->$firstRelation->$distanceRelation->$col ?? '';
            // return $account->user->employee->fullname();
        }

        // Handles one to one relation
        return $model->$relation->$col ?? '';
    }

    public function useModel(){}
    public function getOneModel(string|int $id){}
    public function updateImageColumn(string|int $modelId, string $image){}
    public function breadcrumbData(){}
    public function viewBeforeTable(){}

    public function setCustomRoute($model, $callback = null)
    {
        if(!is_null($callback) && is_string($callback)){
            return call_user_func([$this, $callback], $model);
        }
    }

    public function useSideModal(){}
    public function panelWidth()
    {
        return 'inherit';
    }
    
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

    public function cardListingWrapper(): string
    {
        return 'white-list-wrapper';
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
        $cleanFilename = str($this->selectedImageName)->stripTags()->slug()->value();

        // dd($this->inlineImagesNames, $this->inlineImages, $this->selectedImageName);
        $image = $this->uploadInlineImage(
            data: [
                'image' => $this->inlineImages[$this->modelImageId][0],
                'filename' => $cleanFilename
            ]
        );

        $updatedImage = $this->updateImageColumn($this->modelImageId, $image);

        if($updatedImage){
            session()->flash('inline-upload-success'.$this->modelImageId);
        }
    }
    public function showTableCta()
    {
        return true;
    }

    public function showPagination()
    {
        return false;
    }

    public function showRecordCount()
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

    public function hasCardListing()
    {
        return false;
    }

    public function listAsCards(): string|View|null
    {
        return null;
    }

    public function withListCardImage(): string|View
    {
        return 'editable';
    }

    public function mobileEditImageName($record): string
    {
        return '';
    }

    public function mobileImageFile($record): string|null
    {
        return '';
    }

    public function mobileMoreCtaCss(): string
    {
        return 'bg-goldrod';
    }

    /**
     * return collection with keys: form and title
     */
    public function withListCardEdit($record): CardEdit|Collection|false
    {
        return false;
    }

    public function withCardModalData($record): Collection
    {
        return collect([]);
    }

    public function withCardModalView(): string|View
    {
        return '';
    }

    public function mobileModalCta(): bool
    {
        return false;
    }
    
    public function showTableToCards()
    {
        return false;
    }

    public function tableAsCardsView()
    {
        return '';
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
        return view('slim-dashboard::livewire.tables.base-table')
        ->layoutData(['breadcrumb' => $this->breadcrumbData()])
        ->title($this->pageTitle);
    }
}
