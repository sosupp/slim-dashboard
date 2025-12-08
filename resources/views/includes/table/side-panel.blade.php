<div x-cloak x-show="sidePanel"
    :class="panelAsModal ? 'global-modal-parent' : ''">
    <div class="{{$this->useSideModal() ? 'side-modal-overlay' : ''}}" x-on:click="closePanel"></div>
    <div class=""
        :style="{width: '{{$this->panelWidth()}}'}"
        :class="panelAsModal ? 'global-modal-panel' : 'side-modal-panel'">
        {{-- @includeIf($this->tableForm()) --}}
        <div class="side-modal-heading-wrapper">
            <p class="side-modal-heading" x-html="sidePanelTitle">Side Modal Heading</p>
            <span class="close-modal as-pointer" x-on:click="closePanel">
                <x-slim-dashboard::icons.close />
            </span>
        </div>

        <div class="dashboard-errors-wrapper">
            @forelse ($errors->all() as $message)
                <p class="error">{{$message}}</p>
            @empty

            @endforelse
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

        <div wire:loading.delay.longest>
            <div class="full-table-loading">
                <div class="loading-spinner">
                    <x-slim-dashboard::icons.bars-spinner-fade w="50" h="50" />
                </div>
            </div>
        </div>
    </div>
</div>
