{{-- @props(['record' => []]) --}}
<template x-if="modalRecord">
    <div>
    @if ($action['isVisible'])
        @if ($action['label'] === 'delete')
            @if ($modalRecordDeleted)
            <button class="cta-btn restore-btn as-pointer card-item-modal-cta"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'"
                x-on:click="$wire.restorable(modalRecordId, {{$action['isAuthorize']}});cardModal=false"
                wire:confirm="Are you sure you want to restore?">Restore</button>
            @else
            <button class="cta-btn delete as-pointer card-item-modal-cta"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'"
                x-on:click="$wire.delete(modalRecordId, {{$action['isAuthorize']}});cardModal=false"
                wire:confirm="Are you sure you want to delete?">Delete</button>
            @endif
        @else
            @if (isset($action['customRoute']) && ($action['customRoute']))
                <a wire:navigate href="{{ $this->setCustomRoute($modalRecord, $action['customRoute']) ?: '#' }}"
                class="cta-btn card-item-modal-cta"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'">{{ $action['label'] }}</a>
            @elseif ($action['sidePanel'])
                <button type="button" class="cta-btn as-pointer card-item-modal-cta"
                    x-on:click="toggleSidePanel('{{$action['component']}}','{{$action['panelHeading']}}', modalRecordId)"
                    :class="darkmode ? 'dmode-btn' : 'cta-btn-border'">
                    {{ $action['label'] }}
                </button>
            @elseif ($action['asCheckbox'])

            @elseif ($action['asModal'])
                <button type="button" class="cta-btn cta-btn-border as-pointer {{$action['css'] ?? ''}} {{$this->selectAll ? 'bg-aquamarine' : ''}}"
                    x-on:click="$dispatch('globalmodal', {
                        title: '{{$action['panelHeading']}}',
                        component: '{{$action['component']}}'
                    })"
                    wire:loading.attr="disabled"
                    wire:target="{{$action['wireAction']}}"
                    >{{ $action['label'] }}
                </button>
            @elseif ($action['link'] === 'button')
                <button type="button" class="cta-btn as-pointer card-item-modal-cta"
                    x-on:click="$wire.{{ $action['wireAction'] }}(modalRecordId)"
                    :class="darkmode ? 'dmode-btn' : 'cta-btn-border'"
                    {{$action['confirm'] ? 'wire:confirm' : ''}}>
                    {{ $action['label'] }}

                </button>
            @elseif ($action['link'] === 'more')
            <button type="button" class="cta-btn as-pointer card-item-modal-cta"
                x-on:click="toggleTableSidePanel(withMoreData, '{{$action['panelHeading']}}')"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'"
                {{$action['confirm'] ? 'wire:confirm' : ''}}>
                {{ $action['label'] }}
            </button>
            @else
                @if (!empty($action['link']))
                    <a wire:navigate
                    x-bind:href="modalRecordId ? '{{ route($action['link'], ':id') }}'.replace(':id', modalRecordId) : '#'"
                    class="cta-btn card-item-modal-cta"
                    :class="darkmode ? 'dmode-btn' : 'cta-btn-border'">
                        {{ $action['label'] }}
                    </a>
                @else
                    <a wire:navigate href="#"
                    class="cta-btn card-item-modal-cta"
                    :class="darkmode ? 'dmode-btn' : 'cta-btn-border'">{{ $action['label'] }}</a>
                @endif

            @endif
        @endif
    @endif
    </div>
</template>


