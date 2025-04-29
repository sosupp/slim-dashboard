<?php
namespace Sosupp\SlimDashboard\Html;

use Sosupp\SlimDashboard\Concerns\HtmlForms\Icons;
use Sosupp\SlimDashboard\Concerns\HtmlForms\InputDataTransform;


class HtmlForm
{
    use Icons, InputDataTransform;

    public $form = '';
    public $tabWrapper = '';
    public $tabItems = [];
    public $inputElements = [];

    public static $tabHeadings = [];
    public static $tabContent = [];
    public static $externalView = [];

    public $newTabHeadings = [];

    public $gridContents = [];

    public static $selectedKey = '';
    public string $selectedTab = '';

    public bool $asTabContent = false;

    protected bool $asAlpineTabbing = false;

    protected string $wrapperCss = '';
    protected string $labelCss = '';
    protected string $inputCss = '';

    public function __construct(public string $css = '')
    {
        // $this->prepare();
    }


    public function __toString()
    {
        return $this->build();
    }

    public function prepare()
    {
        $wrapper = '';
        $wrapper .= <<<FORM

            <form class="test-form-wrapper $this->css">
        FORM;

        // $form .= csrf_token();

        $this->form .= $wrapper;
    }

    public static function make()
    {
        return new static;
    }

    public function tabContent(string|array $label = [], Object|null $elements)
    {
        $this->asTabContent = true;
        $this->tabItems[] = $label;
        $this->inputElements[] = $elements;

        dd($elements, $label);


        $this->form .= <<<WRAPPER
            <div class="tab-content-wrapper"
                x-data>
                <div class="tab-item-heading">
                    <h1>$label</h1>
                </div>

                <div class="selected-tab-items">
                    <div class="order-items-wrapper">



            WRAPPER;

            // dd((string) $elements);

            $this->form .= (string) $elements;
            // dd($this->form. (string) $elements);
        // foreach($elements as $element){

        //     $this->form .= $element;
        // }
        return $this;

    }

    public function tabs(string $name, $content, string $externalView = '', ?string $key = null): static
    {
        $useKey = is_null($key) ? $name : $key;
        static::$tabHeadings[] = $name;
        // static::$tabHeadings[$name]['name'] = $name;

        static::$tabContent[$useKey]['key'] = $useKey;
        static::$tabContent[$useKey]['heading'] = $name;
        static::$tabContent[$useKey]['content'] = $content;
        static::$tabContent[$useKey]['externalView'] = $externalView;
        static::$externalView[$name] = $externalView;

        return new static;
    }

    public function grid($content)
    {
        $this->gridContents[] = $content;
        return $this;
    }

    public function selectedTab(string $name)
    {
        $this->selectedTab = $name;

        return $this;
    }

    public function withAlpineTabbing()
    {
        $this->asAlpineTabbing = true;
        return $this;
    }

    public function commonInputCss(
        string $wrapperCss = '',
        string $labelCss = '',
        string $inputCss = '',
    )
    {
        $this->wrapperCss = $wrapperCss;
        $this->labelCss = $labelCss;
        $this->inputCss = $inputCss;

        return $this;
    }

    public function specialInput()
    {
        $this->wrapperCss = 'special-input-wrapper';
        $this->labelCss = 'special-input-label inherit-bg';
        $this->inputCss = 'special-input';

        return $this;
    }

    public function div(
        string $id = '',
        string $content = '',
        string $wrapperCss = 'custom-input-wrapper',
        bool $canView = true,
    )
    {
        $emptyDiv = '';

        if($canView){
            $emptyDiv = <<<EMPTY
                <div class="$wrapperCss" id="$id">
                    $content
                </div>
            EMPTY;
        }

        $this->form .= $emptyDiv;
        return $this;
    }

    public function imageInput(
        $imagePath = null,
        $wrapperCss= "image-preview",
        $labelCss = 'custom-add-input'
    )
    {
        $useLoader = $this->loaderIcon();
        $successIcon = $this->successIcon();

        $progress = '$event.detail.progress';
        $imageWrapper = <<<WRAPPER
        <div class="$wrapperCss"
            x-data="{
                progress: 0,
                uploading: false,
                isSuccess: false,
            }"
            x-on:livewire-upload-start="uploading = true"
            x-on:livewire-upload-finish="uploading = false;isSuccess=true"
            x-on:livewire-upload-cancel="uploading = false"
            x-on:livewire-upload-error="uploading = false"
            x-on:livewire-upload-progress="progress = $progress">

            <div class="upload-indicators" x-cloak x-show="uploading">
                <span class="upload-indicator">$useLoader</span>
            </div>

            <div class="upload-indicators" x-cloak x-show="isSuccess">
                <span class="upload-indicator">$successIcon</span>
            </div>
        WRAPPER;

        if ($imagePath) {
            $useImage = asset($imagePath);
            $imageWrapper .= <<<IMAGE
            <template x-if="!imgsrc">
                <img src="$useImage" class="overlay-image">
            </template>
            IMAGE;
        }



        $imageWrapper .= <<<PREVIEW
            <template x-if="imgsrc">
                <p>
                    <img src="" :src="imgsrc" class="overlay-image">
                </p>

            </template>
        PREVIEW;

        $useIcon = $this->plusIcon(class: 'add-image-icon plus-icon');

        $imageWrapper .= <<<IMAGE
                <div class="custom-input-wrapper" id="imageForm">
                    <label for="uploadImage" class="custom-add-input as-pointer">
                        <input type="file" id="uploadImage"
                            wire:model="image"
                            x-ref="uploadedImage"
                            x-on:change="previewImage(),isSuccess=false">

                        $useIcon
                        <div class="add-image-icon">
                            Add image
                        </div>
                    </label>
                </div>
        </div>
        IMAGE;

        $this->form .= $imageWrapper;
        return $this;
    }

    public function inlineImageInput(
        string $name,
        string $type = 'file',
        string $value = '',
        string $id = '',
        string|null $label = null,
        string $placeholder = '',
        string $class = '',
        string $message = '',
        bool|string $wireLive = false,
        string $wrapperCss = 'custom-input-wrapper',
        string $labelCss = '',
        string $inputCss = 'custom-input',
        bool $canView = true,
    )
    {
        $setLabel = is_null($label) ? $name : $label;
        $setState = $wireLive === 'blur' ? '.blur' : ($wireLive ? '.live' : '.defer');

        $uploadIcon = $this->useIcon(path: 'icons.upload', color: 'currentColor');
        $successMark = $this->useIcon(path: 'utils.alerts.success');
        $useLoader = $this->loaderIcon();

        $wrapperCss = empty($this->wrapperCss) ? $wrapperCss : $this->wrapperCss;
        $labelCss = empty($this->labelCss) ? $labelCss : $this->labelCss;
        $inputCss = empty($this->inputCss) ? $inputCss : $this->inputCss;

        $input = '';

        $progress = '$event.detail.progress';
        $setFile = 'this.$refs.uploadedImage.files[0]';
        $input = <<<WRAPPER
            <div x-data="{
                    progress: 0,
                    uploading: false,
                    isSuccess: false,
                    previewImage(){
                        let file = $setFile;
                        filename = file.name;
                        if (!file || file.type.indexOf('image/') === -1) return;
                        this.imagePreview = null;

                        let reader = new FileReader();
                        reader.onload = e => {
                            this.imagePreview = e.target.result
                        }

                        reader.readAsDataURL(file);
                    }
                }"
                x-on:livewire-upload-start="uploading = true"
                x-on:livewire-upload-finish="uploading = false;isSuccess=true"
                x-on:livewire-upload-cancel="uploading = false"
                x-on:livewire-upload-error="uploading = false"
                x-on:livewire-upload-progress="progress = $progress"
                class="image-upload-wrapper">
                    <input type="file"
                        style="display: none;"
                        id="imageInput"
                        class="image-input-file"
                        x-ref="uploadedImage"
                        x-on:change="previewImage()"
                        wire:model$setState="$name">

                    <label for="imageInput"
                        class="image-upload-label as-pointer">
                        $setLabel
                    </label>

                    <div class="image-preview-container">
                        <img :src="imagePreview"
                            alt="Selected Image"
                            class="selected-image-preview">
                        <div class="image-upload-icon">
                            $uploadIcon
                        </div>
                    </div>

                <div class="progress-indicator">
                    <div x-show="uploading" x-cloak>$useLoader</div>
                    <div x-show="isSuccess" x-cloak>$successMark</div>
                </div>

            </div>
        WRAPPER;

        $this->form .= $input;

        return $this;
    }


    public function searchInput(
        string $name,
        string $type = 'search',
        string $value = '',
        string $id = '',
        string|null $label = null,
        string $placeholder = '',
        string $class = '',
        string $message = '',
        bool|string $wireLive = false,
        string $wrapperCss = 'custom-input-wrapper',
        string $labelCss = '',
        string $inputCss = 'custom-input',
        string $resultView = '',

    )
    {
        $setLabel = is_null($label) ? $name : $label;
        $setId = empty($id) ? $setLabel : $id;
        $setState = $wireLive === 'blur' ? '.blur' : ($wireLive ? '.live' : '.defer');

        $wrapperCss = empty($this->wrapperCss) ? $wrapperCss : $this->wrapperCss;
        $labelCss = empty($this->labelCss) ? $labelCss : $this->labelCss;
        $inputCss = empty($this->inputCss) ? $inputCss : $this->inputCss;

        $resultWrapper = '<div class="input-result-wrapper" x-data="{
            openResult: false

        }">';
        $input = <<<INPUT
        <div class="$wrapperCss">
            <label for="$setId" class="$labelCss">$setLabel</label>
            <input type="$type"
                id="$setId"
                class="$inputCss $class @error('$name') is-error @enderror"
                wire:model$setState="$name"
                value="$value"
                placeholder="$placeholder"
                x-on:click="openResult=true"
                />


        </div>
        INPUT;

        $resultWrapper .= $input;

        $resultWrapper .= view($resultView);
        $resultWrapper .= '</div>';

        $this->form .= $resultWrapper;
        return $this;
    }

    public function input(
        string $name,
        string $type = 'text',
        string $value = '',
        string $id = '',
        string|null $label = null,
        string $placeholder = '',
        string $class = '',
        string $message = '',
        bool|string $wireLive = false,
        string $wrapperCss = 'custom-input-wrapper',
        string $labelCss = '',
        string $inputCss = 'custom-input',
        bool $canView = true,
        bool $lock = false,

    )
    {
        $setLabel = is_null($label) ? $name : $label;
        $setId = empty($id) ? $setLabel : $id;
        $setState = $wireLive === 'blur' ? '.blur' : ($wireLive ? '.live' : '.defer');
        $setLocked = $lock ? 'disabled' : '';

        $wrapperCss = empty($this->wrapperCss) ? $wrapperCss : $this->wrapperCss;
        $labelCss = empty($this->labelCss) ? $labelCss : $this->labelCss;
        $inputCss = empty($this->inputCss) ? $inputCss : $this->inputCss;

        $input = '';

        if($canView){
            $input = <<<INPUT
            <div class="$wrapperCss">
                <label for="$setId" class="$labelCss">$setLabel</label>
                <input type="$type"
                    id="$setId"
                    class="$inputCss $class @error('$name') is-error @enderror"
                    wire:model$setState="$name"
                    value="$value"
                    placeholder="$placeholder" $setLocked required
                    wire:key="$setId"/>
            </div>
            INPUT;
        }

        $this->form .= $input;
        return $this;
    }

    public function select(
        string $name,
        string $id = '',
        string|null $label = null,
        string $placeholder = '',
        string $action = '',
        array|null $options = [],
        string $optionKey = 'name',
        string $optionId = 'id',
        string $class = '',
        bool|string $wireLive = true,
        string $wrapperCss = 'custom-input-wrapper',
        string $labelCss = '',
        string $inputCss = 'custom-input',
        bool $customPlaceholder = true,
        bool $canView = true
    )
    {
        $setLabel = is_null($label) ? $name : $label;
        $setId = empty($id) ? $setLabel : $id;
        $setState = $wireLive === 'blur' ? '.blur' : ($wireLive ? '.live' : '.defer');
        $usePlaceholder = $customPlaceholder ? $label : '';

        $wrapperCss = empty($this->wrapperCss) ? $wrapperCss : $this->wrapperCss;
        $labelCss = empty($this->labelCss) ? $labelCss : $this->labelCss;
        $inputCss = empty($this->inputCss) ? $inputCss : $this->inputCss;

        $selectInput = '';

        if($canView){
            $selectInput = <<<SELECT
            <div class="$wrapperCss">
                <label for="$setId" class="$labelCss">$setLabel</label>
                <select class="$inputCss @error('$name') is-error @enderror"
                    id="$setId"
                    wire:model$setState="$name"
                    wire:key="$name"
                    $action>
            SELECT;

            $selectInput .= <<<DEFAULT
            <option>$usePlaceholder</option>
            DEFAULT;

            // dd($options);
            $opts = '';
            foreach($options as $index => $option){
                if(!empty($optionKey) && is_array($option)){
                    $opts .= <<<OPTION
                    <option value="$option[$optionId]">$option[$optionKey]</option>
                    OPTION;
                } else{
                    $opts .= <<<OPTION
                    <option value="$option">$option</option>
                    OPTION;
                }
            }

            // dd($opts);
            $selectInput .= $opts;
            $selectInput .= '</select></div>';
        }


        $this->form .= $selectInput;


        return $this;
    }


    public function selectSearch(
        string $name,
        string $id = '',
        string|null $label = null,
        string $placeholder = '',
        string $action = '',
        array|null $options = [],
        string $optionKey = 'name',
        string $optionId = 'id',
        string $class = '',
        bool|string $wireLive = false,
        string $wrapperCss = 'custom-input-wrapper',
        string $labelCss = '',
        string $inputCss = 'custom-input',
        bool $customPlaceholder = false,
    )
    {
        $setLabel = is_null($label) ? $name : $label;
        $setId = empty($id) ? $setLabel : $id;
        $setState = $wireLive === 'blur' ? '.blur' : ($wireLive ? '.live' : '.defer');
        $usePlaceholder = $customPlaceholder ? $label : '';

        $wrapperCss = empty($this->wrapperCss) ? $wrapperCss : $this->wrapperCss;
        $labelCss = empty($this->labelCss) ? $labelCss : $this->labelCss;
        $inputCss = empty($this->inputCss) ? $inputCss : $this->inputCss;

        $this->form .= view('slim-dashboard::components.inputs.select-search', [
            'name' => $name,
            'id' => $setId,
            'label' => $setLabel,
            'placeholder' => $usePlaceholder,
            'action' => $action,
            'options' => $this->selectSearchData($options),
            'optionKey' => $optionKey,
            'optionId' => $optionId,
            'class' => $class,
            'inputCss' => $inputCss,
            'wireState' => $setState,
            'wrapperCss' => $wrapperCss,
            'labelCss' => $labelCss,
        ]);

        return $this;
    }

    public function textarea(
        string $name,
        string $id = 'customEditor',
        string $rows = '3',
        string|null $label = null,
        string $placeholder = '',
        string $action = '',
        bool $withEditor = true,
        string $wrapperCss = 'custom-input-wrapper',
        string $labelCss = '',
        string $inputCss = 'custom-input',
        bool $customPlaceholder = true,
        bool $withImageUpload = true,
    )
    {
        $setLabel = is_null($label) ? $name : $label;
        $setId = empty($id) ? $setLabel : $id;
        $wrapperCss = empty($this->wrapperCss) ? $wrapperCss : $this->wrapperCss;
        $labelCss = empty($this->labelCss) ? $labelCss : $this->labelCss;
        $inputCss = empty($this->inputCss) ? $inputCss : $this->inputCss;

        if($withEditor === false){
            $this->form .= $this->plainEditor(id: $setId, model: $name, wrapperCss: $wrapperCss, labelCss: $labelCss, inputCss: $inputCss, label: $setLabel);
            return $this;
        }

        if($withImageUpload){
            $this->form .= $this->ckEditor(id: $setId, model: $name, label: $setLabel);
        }else{
            $this->form .= $this->ckEditorWithoutUpload(id: $setId, model: $name, wrapperCss: $wrapperCss, labelCss: $labelCss, inputCss: $inputCss, label: $setLabel);
        }

        return $this;
    }

    public function textEditor(
        string $name,
        string $id = 'customEditor',
        string|null $label = null,
        string $wrapperCss = 'custom-input-wrapper',
        string $labelCss = '',
        string $inputCss = 'custom-input',
        bool $customPlaceholder = true,
        bool $withImageUpload = true,
        string $uploadEndpoint = '/slimdashboard/editor/image/adaptor'
    )
    {
        $setLabel = is_null($label) ? $name : $label;
        $setId = empty($id) ? $setLabel : $id;
        $wrapperCss = empty($this->wrapperCss) ? $wrapperCss : $this->wrapperCss;
        $labelCss = empty($this->labelCss) ? $labelCss : $this->labelCss;
        $inputCss = empty($this->inputCss) ? $inputCss : $this->inputCss;

        $this->form .= view('slim-dashboard::includes.platform.editors.quill', [
            'model' => $name,
            'id' => $setId,
            'class' => $wrapperCss,
            'uploadEndpoint' => $uploadEndpoint
        ]);

        return $this;
    }

    public function button(
        string $label = '',
        string $type = 'button',
        string $id = 'publishBtn',
        string $action = '',
        string $wire = '',
        string $wireTarget = 'save',
        string $class = 'standard-btn',
        string $defaultSave = 'save',
        bool $isUpdate = false,
        bool $canView = true,
    )
    {
        $useWire = empty($defaultSave) ? $wire : 'click.prevent='.$defaultSave;
        $useLabel = empty($label) ? ($isUpdate ? 'Update' : 'Save') : $label;

        if($canView){

            $this->form .= <<<BUTTON
            <button type="$type"
                id="$id"
                class="$class as-pointer"
                wire:$useWire
                wire:loading.attr="disabled"
                $action>$useLabel</button>

            BUTTON;

            // $useIcon = '';
            $useIcon = $this->spinnerIcon();
            $this->form .= <<<LOADER
                <div wire:loading wire:target="$wireTarget">
                    $useIcon
                </div>
            LOADER;

        }



        return $this;
    }

    public function wrapper(string $label = '', array $inputs = [])
    {
        $wrapper = '';
        $wrapper .= <<<WRAPPER
        <div class="content-wrapper"
            x-data>
            <div class="tab-item-heading">
                <h1>Heading</h1>
            </div>

        WRAPPER;

        $wrapper.= $this->form;

        $wrapper .=  <<<WRAPPER

            <div class="selected-tab-items">
                <div class="order-items-wrapper">

                </div>
            </div>
        </div>
        WRAPPER;

        // return $wrapper;
        // $this->tabWrapper .= $wrapper;
        return $this;

    }

    public function build()
    {
        // dd($this->selectedTab);
        if(count(static::$tabHeadings) >=1){

            $this->asAlpineTab();

        }elseif(count($this->gridContents) >= 1){

            foreach($this->gridContents as $key => $gridContent){
                // echo $gridContent;
                $this->form .= <<<GRID
                    <div class="grid-content-wrapper bg-white">
                    $gridContent
                    </div>
                GRID;
            }

        }else {

        }

        return $this->form;
    }

    protected function asAlpineTab()
    {
        $useContent = static::$tabContent;
        // dd($useContent, static::$tabHeadings, $this->newTabHeadings);
        $useWire = '$wire';
        $this->form .= <<<WRAPPER
            <div class="tab-content-wrapper"
                x-data="{
                    selectedTab: '$this->selectedTab',
                    isActive: '',
                    toggleActive(tab){
                        this.selectedTab = tab
                        this.isActive = tab
                    }
                }"
                x-cloak>
                <div class="tab-item-heading">
        WRAPPER;

        // Tab headings
        foreach($useContent as $key => $heading){
            $title = $heading['heading'];
            $this->form .= <<<WRAPPER
                <span class="tab-heading as-pointer"
                    :class="'$key'==selectedTab ? 'active-tab' : ''"
                    wire:key="$key"
                    x-on:click="toggleActive('$key')">
                $title
                </span>
            WRAPPER;
        }

        $this->form .= '</div>';

        // Tab contents
        $items = '<div class="selected-tab-items">';
        $content = '';

        foreach ($useContent as $key => $content) {
            if(!empty($content['externalView'])){
                $content = view($content['externalView']);
            } else {
                $content = $content['content'];
            }

            $items .= <<<WRAPPER
                <div x-show="'$key'==selectedTab">

                $content
                </div>

            WRAPPER;
        }

        $items .= '</div>';


        $this->form .= $items;
        $this->form .='</div>';
    }

    protected function livewireTabbing()
    {
        $useWire = '$wire';
        // dd(static::$tabContent, static::$externalView);
        $this->form .= <<<WRAPPER
            <div class="tab-content-wrapper"
                x-data="{
                    selectedTab: '$this->selectedTab',
                    isActive: '$this->selectedTab',
                    toggleActive(tab){
                        this.selectedTab = tab
                        this.isActive = tab
                        $useWire.changeTab(tab)
                        console.log(this.selectedTab, this.isActive)
                    }
                }"
                x-cloak>
                <div class="tab-item-heading">
        WRAPPER;

        foreach(static::$tabHeadings as $heading){
            $activeStatus = $heading === $this->selectedTab ? 'active-tab' : '';
            $this->form .= <<<WRAPPER
                <span class="tab-heading as-pointer $activeStatus"
                    wire:key="'$heading'"
                    x-on:click="toggleActive('$heading')">
                $heading
                </span>
            WRAPPER;
        }

        $this->form .= '</div>';

        $content = '';

        if(!empty(static::$tabContent[$this->selectedTab]['externalView'])){
            $content = view(static::$tabContent[$this->selectedTab]['externalView']);
        } else {
            $content = static::$tabContent[$this->selectedTab]['content'] ?? null;
        }
        // dd($this->selectedTab, static::$tabContent, $content);

        $this->form .= <<<WRAPPER
        <div class="selected-tab-items">
            <div x-show="selectedTab == isActive">
            $content
            <div>
        </div>
        WRAPPER;

        $this->form .= '</div>';
    }

    private function error($name)
    {
        return <<<'BLADE'
            @error($name)
                <span class="error">{{$message}}</span>
            @enderror
        BLADE;
    }

    private function plainEditor(string $id, string $model, string $wrapperCss, string $labelCss, string $inputCss, string $label)
    {
        return view('slim-dashboard::components.utils.forms.plain-editor', compact('id', 'model', 'wrapperCss', 'labelCss', 'inputCss', 'label'));
    }

    private function ckEditor(string $id, string $model, string $label)
    {
        return view('slim-dashboard::components.utils.forms.ckeditor', compact('id', 'model', 'label'));
    }

    private function ckEditorWithoutUpload(string $id, string $model, string $wrapperCss, string $labelCss, string $inputCss, string $label)
    {
        return view('slim-dashboard::components.utils.forms.no-upload-ckeditor', compact('id', 'model', 'wrapperCss', 'labelCss', 'inputCss', 'label'));
    }


}

