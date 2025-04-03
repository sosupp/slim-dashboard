@props([
    'data' => [],
    'baseLabel' => '$baseLabel',
    'baseUrl' => null,
    'currentPage' => '$currentPage',
    'wireAction' => false,
])
<div class="page-breadcrumb-wrapper dashboard-breadcrumb" x-data>

    @foreach ($data as $nav)
        @if (isset($nav['isBase']) && $nav['isBase'])
        <span class="base-nav base-page breadcrumb-item purple-font">
            <a wire:navigate href="{{ $nav['url'] }}">{{ $nav['name'] }}</a>
        </span>
        <span> <x-slim-dashboard::icons.chevron-right class="text-sm text-gray-600" /> </span>
        @else
            @if (isset($nav['isCurrent']) && $nav['isCurrent'])
            <span class="base-nav current-page breadcrumb-item"> {{ $nav['name'] }} </span>
            @else
            <span class="breadcrumb-item">
                <a wire:navigate href="{{ $nav['url'] }}">{{ $nav['name'] }}</a>
            </span>
            <span> <x-slim-dashboard::icons.chevron-right class="text-sm text-gray-600" /> </span>
            @endif

        @endif

    @endforeach

</div>
