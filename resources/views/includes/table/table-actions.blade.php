@props(['screen' => 'all', 'record'])
@php
    $visible = is_callable($action['isVisible'])
        ? $action['isVisible']($record)
        : $action['isVisible'];
@endphp

@if (@$record)
    @if ($visible && $action['screen'] === $screen)
        @if ($action['label'] === 'delete')
            @if ($record->deleted_at)
            <button class="cta-btn restore-btn as-pointer modal-cta-item"
                title="{{ $action['label'] }}"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'"
                wire:click="restorable({{ $record->id }}, {{$action['isAuthorize']}})"
                wire:confirm="Are you sure you want to restore?">Restore</button>
            @else
            <button class="cta-btn delete as-pointer modal-cta-item"
                title="{{ $action['label'] }}"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'"
                wire:click="delete({{ $record->id }}, {{$action['isAuthorize']}})"
                wire:confirm="Are you sure you want to delete?">

                @if ($action['icon'])
                    <i class="fas {{$action['icon']}}"></i>
                @else
                    Delete
                @endif

            </button>

            @endif
        @else
            @if (isset($action['customRoute']) && ($action['customRoute']))
                <a wire:navigate href="{{ $this->setCustomRoute($record, $action['customRoute']) ?: '#' }}"
                class="cta-btn modal-cta-item"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'">{{ $action['label'] }}</a>
            @elseif ($action['sidePanel'])
                <button type="button" class="cta-btn as-pointer modal-cta-item"
                    title="{{ $action['label'] }}"
                    x-on:click="toggleSidePanel(
                        '{{$action['component']}}',
                        '{{$action['panelHeading']}}',
                        '{{$record->id}}',
                        '{{$action['asModal']}}'
                    )"
                    :class="darkmode ? 'dmode-btn' : 'cta-btn-border'">
                    @if ($action['icon'])
                        <i class="fas {{$action['icon']}}"></i>
                    @else
                        {{ $action['label'] }}
                    @endif
                </button>
            @elseif ($action['asCheckbox'])

            @elseif ($action['asModal'])
                <button type="button" class="cta-btn cta-btn-border as-pointer {{$action['css'] ?? ''}} {{$this->selectAll ? 'bg-aquamarine' : ''}}"
                    title="{{ $action['label'] }}"
                    x-on:click="$dispatch('globalmodal', {
                        title: '{{$action['panelHeading']}}',
                        component: '{{$action['component']}}'
                    })"
                    wire:loading.attr="disabled"
                    wire:target="{{$action['wireAction']}}"
                    >
                    @if ($action['icon'])
                        <i class="fas {{$action['icon']}}"></i>
                    @else
                        {{ $action['label'] }}
                    @endif
                </button>

            @elseif ($action['link'] === 'button')
                <button type="button" class="cta-btn as-pointer modal-cta-item"
                    title="{{ $action['label'] }}"
                    wire:click="{{$action['wireAction'].'('.$record.')'}}"
                    :class="darkmode ? 'dmode-btn' : 'cta-btn-border'"
                    {{$action['confirm'] ? 'wire:confirm' : ''}}>
                    @if ($action['icon'])
                        <i class="fas {{$action['icon']}}"></i>
                    @else
                        {{ $action['label'] }}
                    @endif
                </button>

            @elseif ($action['link'] === 'more')
            <button type="button" class="cta-btn as-pointer modal-cta-item"
                title="{{ $action['label'] }}"
                x-on:click="toggleTableSidePanel({{$record}}, '{{$action['panelHeading']}}')"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'"
                {{$action['confirm'] ? 'wire:confirm' : ''}}>
                @if ($action['icon'])
                    <i class="fas {{$action['icon']}}"></i>
                @else
                    {{ $action['label'] }}
                @endif
            </button>
            @else
            <a wire:navigate title="{{ $action['label'] }}"
                href="{{ !empty($action['link']) ? route($action['link'], $record->id) : '#' }}"
                class="cta-btn modal-cta-item"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'">
                @if ($action['icon'])
                    <i class="fas {{$action['icon']}}"></i>
                @else
                    {{ $action['label'] }}
                @endif
            </a>
            @endif
        @endif
    @endif
@endif

