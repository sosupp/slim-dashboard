<div x-cloak x-show="sidePanel">
    <div class="{{$this->useSideModal() ? 'side-modal-overlay' : ''}}" x-on:click="closePanel"></div>
    <div class="table-form {{$this->useSideModal() ? 'side-modal-panel' : ''}}">
        {{-- @includeIf($this->tableForm()) --}}
        <div class="side-modal-heading-wrapper">
            <p class="side-modal-heading" x-text="sidePanelTitle">Side Modal Heading</p>
            <span class="close-modal as-pointer" x-on:click="closePanel">
                <x-icons.close />
            </span>
        </div>

        <template x-if="useComponent">
            <div>
                @includeIf('$sidePanelComponent')
                {!! $this->panelCustomView() !!}
            </div>
        </template>

        <template x-if="!useComponent">
            <div>
                {!! $this->panelExtraView() !!}

                @if($this->hasCustomDatePanel())
                    @include('slim-dashboard::includes.table.custom-date-selector')
                @endif
                

                {!! $this->tableForm() !!}
            </div>

        </template>
    </div>
</div>
