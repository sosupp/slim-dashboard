<?php
namespace Sosupp\SlimDashboard\Html;

use Sosupp\SlimDashboard\Concerns\HtmlForms\Icons;


class HtmlForm
{
    use Icons;

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

    public function imageInput(
        $imagePath = null,
    )
    {
        $imageWrapper = <<<'BLADE'
        <div class="image-preview">
            <label for="">Image</label>
            <div class="overlay-preview">
        BLADE;

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
                            x-on:change="previewImage()">

                        $useIcon
                        <div class="add-image-icon">
                            Add one or multiple images
                        </div>
                    </label>
                </div>
            </div>
        </div>
        IMAGE;

        $this->form .= $imageWrapper;
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
        bool $wireLive = false,

    )
    {
        $setLabel = is_null($label) ? $name : $label;
        $setState = $wireLive ? '' : '.defer';

        $input = <<<INPUT
        <div class="custom-input-wrapper">
            <label for="$id">$setLabel</label>
            <input type="$type"
                id="$id"
                class="custom-input $class @error('$name') is-error @enderror"
                wire:model$setState="$name"
                value="$value"
                placeholder="$placeholder" />
        </div>
        INPUT;

        // $error = $this->error($name);

        // $input .= $this->error($name);

        // if($type === 'file' && !empty($value)){

        // }

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
        bool $wireLive = true,
    )
    {
        $setLabel = is_null($label) ? $name : $label;
        // $wireIgnore = $action = 'multiple' ? 'wire:ignore' : '';
        $setState = $wireLive ? '.live' : '';

        $selectInput = <<<SELECT
        <div class="custom-input-wrapper">
            <label for="$id">$setLabel</label>
            <select class="custom-input $class @error('$name') is-error @enderror"
                id="$id"
                wire:model$setState="$name"
                wire:key="$name"
                $action>
        SELECT;

        $selectInput .= <<<DEFAULT
        <option>Select $label</option>
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

        $this->form .= $selectInput;


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
    )
    {
        $setLabel = is_null($label) ? $name : $label;
        // $setId

        $textarea = <<<TEXTAREA
        <div class="custom-input-wrapper">
            <label for="$id">$setLabel</label>
            <div wire:ignore wire:key="custom_editor_$name">
                <textarea
                    id="$id"
                    rows="$rows"
                    wire:model.defer="$name"
                    data-content="@this"
                    class="custom-input hero-textarea"
                    placeholder="$placeholder"
                    $action></textarea>
            </div>
        </div>
        TEXTAREA;

        $this->form .= $textarea;

        // if($withEditor){
        //     $this->form .= $this->ckEditor(id: $id, model: $name);
        // }
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
    )
    {
        $useWire = empty($defaultSave) ? $wire : 'click.prevent='.$defaultSave;
        $useLabel = empty($label) ? ($isUpdate ? 'Update' : 'Save') : $label;

        $this->form .= <<<BUTTON
        <button type="$type"
            id="$id"
            class="$class"
            wire:$useWire
            $action>$useLabel</button>

        BUTTON;

        // $useIcon = '';
        $useIcon = $this->spinnerIcon();
        $this->form .= <<<LOADER
            <div wire:loading wire:target="$wireTarget">
                $useIcon
            </div>
        LOADER;

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

    private function ckEditor(string $id, string $model)
    {
        // dd($id);
        return view('components.utils.forms.ckeditor', compact('id', 'model'));

        // $useId = '#'.$id;
        // $scripts = <<< BLADE
        //     <script>
        //         var ready = (callback) => {
        //             if (document.readyState != "loading") callback();
        //             else document.addEventListener("DOMContentLoaded", callback);
        //         }

        //         ready(() =>{
        //             ClassicEditor
        //                 .create(document.querySelector("#customEditor"), {
        //                     simpleUpload: {
        //                         uploadUrl: "{{route('editor.image.upload').'?_token='.csrf_token() }}",
        //                     },
        //                     removePlugins: [

        //                     ],
        //                     fontSize: {
        //                         options: [
        //                             'default'
        //                         ]
        //                     }
        //                 })
        //                 .then(editor => {
        //                     editor.model.document.on('change:data', () => {
        //                         '@'+this.set('content', editor.getData())
        //                     })
        //                 })
        //                 .catch(error => {
        //                     console.error(error);
        //                 });
        //         })

        //     </script>
        // BLADE;

        // return $scripts;
    }


}

