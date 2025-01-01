@if ($action['isVisible'])
    @if ($action['label'] === 'delete')
        <button class="cta-btn delete as-pointer"
            :class="darkmode ? 'dmode-btn' : 'cta-btn-border'"
            wire:click="delete({{ $record->id }}, {{$action['isAuthorize']}})"
            wire:confirm="Are you sure you want to delete?">delete</button>
    @else
        @if (isset($action['customRoute']) && ($action['customRoute']))
            <a wire:navigate href="{{ $this->setCustomRoute($record) ?: '#' }}"
            class="cta-btn"
            :class="darkmode ? 'dmode-btn' : 'cta-btn-border'">{{ $action['label'] }}</a>
        @elseif ($action['sidePanel'])
            <button type="button" class="cta-btn as-pointer"
                x-on:click="toggleSidePanel('{{$action['component']}}','{{$action['panelHeading']}}', '{{$record->id}}')"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'">
                {{ $action['label'] }}
            </button>
        @elseif ($action['asCheckbox'])

        @elseif ($action['link'] === 'button')
            <button type="button" class="cta-btn as-pointer"
                wire:click="{{$action['wireAction'].'('.$record.')'}}"
                :class="darkmode ? 'dmode-btn' : 'cta-btn-border'"
                {{$action['confirm'] ? 'wire:confirm' : ''}}>
                {{ $action['label'] }}

            </button>
        @else
        <a wire:navigate
            href="{{ !empty($action['link']) ? route($action['link'], $record->id) : '#' }}"
            class="cta-btn"
            :class="darkmode ? 'dmode-btn' : 'cta-btn-border'">{{ $action['label'] }}</a>
        @endif
    @endif
@endif

