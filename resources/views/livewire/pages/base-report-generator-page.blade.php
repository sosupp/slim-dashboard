<div x-data="{
        sidePanel: $wire.entangle('hasSidePanel'),
        sidePanelTitle: '',
        useComponent: false,
        componentName: $wire.entangle('sidePanelComponent').live,
        subActive(key){
            this.subnav = key
        },
        toggleSidePanel(component = '', title = '', record = null){
            this.sidePanelTitle = title
            this.sidePanel = !this.sidePanel
            if(component !== ''){
                this.useComponent = true
                this.componentName = component
            }else {
                this.useComponent = false
            }
            if(record !== null){
                $wire.sidePanelModel(record)
                $wire.resolvePanelModel(record)
            }
        },
        closePanel(){
            this.sidePanel = !this.sidePanel
        }
    }" x-init="bottomNav=false">
    {{-- <div class="total-record-count">Generate Report</div> --}}

    <div class="report-generator-ctas">
        <div class="report-format-wrapper">
            <x-inputs.special.select
                state=""
                label="Select report"
                inputCss="bg-white reset-padding"
                :allowLabel="false"
                marginReset="0"
                name="reportModel"
                :options="$this->reportModels"
                optionKey="name"
                optionId="key"
                class="reset-sepcial-margin report-select-wrapper"
            />

            <div class="report-cta-wrapper">
                <div class="filters-and-cta">
                    @include('slim-dashboard::includes.table.table-filters')
                </div>

                <div>
                    <button class="standard-btn" wire:click="processReport()" wire:target="processReport()">Generate</button>
                </div>
            </div>
        </div>


    </div>



    <div class="report-table-presentation">
        <div wire:loading>
            <div class="full-table-loading">
                <div class="loading-spinner">
                    <x-icons.bars-spinner-fade w="50" h="50" />
                </div>
            </div>
        </div>

        @if (isset($componentName) && !empty($componentName))
            @livewire($componentName, $this->passExtraData(), key($componentName))
        @else
            @includeIf($this->useViewFile, $this->passExtraData())
        @endif
    </div>

    @if ($this->useSideModal())
    @include('includes.table.side-panel')
    @endif



</div>
