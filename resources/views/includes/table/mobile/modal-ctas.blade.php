{{-- @props(['record' => []]) --}}
<template x-if="modalRecord">
    <div>
        @if ($action['isVisible'])
        @if ($action['label'] === 'delete')
            @if ($modalRecordDeleted)
            <button class="cta-btn restore-btn as-pointer modal-cta-item"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'"
                wire:click="restorable({{ $modalRecordId }}, {{$action['isAuthorize']}})"
                wire:confirm="Are you sure you want to restore?"
                x-on:click="cardModal=false">Restore</button>
            @else
            <button class="cta-btn delete as-pointer modal-cta-item"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'"
                wire:click="delete({{ $modalRecordId }}, {{$action['isAuthorize']}})"
                wire:confirm="Are you sure you want to delete?"
                x-on:click="cardModal=false">Delete</button>
            @endif
        @else
            @if (isset($action['customRoute']) && ($action['customRoute']))
                <a wire:navigate href="{{ $this->setCustomRoute($modalRecord, $action['customRoute']) ?: '#' }}"
                class="cta-btn modal-cta-item"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'">{{ $action['label'] }}</a>
            @elseif ($action['sidePanel'])
                <button type="button" class="cta-btn as-pointer modal-cta-item"
                    x-on:click="toggleSidePanel('{{$action['component']}}','{{$action['panelHeading']}}', '{{$modalRecordId}}')"
                    :class="darkmode ? 'dmode-btn' : 'cta-btn-border'">
                    {{ $action['label'] }}
                </button>
            @elseif ($action['asCheckbox'])

            @elseif ($action['link'] === 'button')
                <button type="button" class="cta-btn as-pointer modal-cta-item"
                    wire:click="{{$action['wireAction'].'('.$modalRecordId.')'}}"
                    :class="darkmode ? 'dmode-btn' : 'cta-btn-border'"
                    {{$action['confirm'] ? 'wire:confirm' : ''}}>
                    {{ $action['label'] }}

                </button>
            @else
            <a wire:navigate
                href="{{ !empty($action['link']) ? route($action['link'], $modalRecordId) : '#' }}"
                class="cta-btn modal-cta-item"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'">{{ $action['label'] }}</a>
            @endif
        @endif
    @endif
    </div>
</template>


