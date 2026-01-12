<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>

    {{-- <link rel="stylesheet" href="{{ asset('css/dashboard/main.css')}}"> --}}
    <link rel="stylesheet" href="{{ mix_vendor('css/dashboard/dashboard.css', 'slim-dashboard') }}">
    <link rel="stylesheet" href="{{ mix_vendor('css/dashboard/table.css', 'slim-dashboard') }}">
    <link rel="stylesheet" href="{{ mix_vendor('css/dashboard/inputs.css', 'slim-dashboard') }}">
    <link rel="stylesheet" href="{{ mix_vendor('css/modal.css', 'slim-dashboard') }}">
    <link rel="stylesheet" href="{{ mix_vendor('css/dashboard/form.css', 'slim-dashboard') }}">
    <link rel="stylesheet" href="{{ mix_vendor('css/dashboard/wrappers.css', 'slim-dashboard') }}">
    <link rel="stylesheet" href="{{ mix_vendor('css/dashboard/utilities.css', 'slim-dashboard') }}">

    <link rel="stylesheet" href="{{ mix_vendor('css/dashboard/accounts.css', 'slim-dashboard') }}">
    <link rel="stylesheet" href="{{ mix_vendor('css/dashboard/accounting.css', 'slim-dashboard') }}">

    @stack('css')
    @include('slim-dashboard::includes.assets.normalizer')

    <script src="{{ mix_vendor('js/dashboard.js', 'slim-dashboard') }}"></script>

    <style>
        .global-layout {
            width: 1250px;
            max-width: 100%;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .nav-card-selectors {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }
        .nav-card-selector {
            background: #fff;
            box-shadow: rgba(60,64,67,0.3) 0px 1px 2px 0px,rgba(60,64,67,0.15) 0px 1px 3px 1px;
            padding: 20px;
            border-radius: 10px;
            min-height: 200px;
            display: flex;
            flex-direction: column; /* Stack icon and heading vertically */
            align-items: center;    /* Center horizontally */
            justify-content: center; /* Center vertically */
            text-align: center;     /* Ensure text aligns center */
            height: 100%;

        }
        .nav-card-selector-content {
            display: flex;
            flex-direction: column; /* Stack icon and heading vertically */
            align-items: center;    /* Center horizontally */
            justify-content: center; /* Center vertically */
            text-align: center;     /* Ensure text aligns center */
            height: 100%;           /* Optional: full height of parent */
        }

        .nav-card-selector:hover {
            border: 2px solid lemonchiffon;
        }
        .page-section-heading {
            margin: 10px 0;
        }

        .nav-card-selector-heading {
            font-size: 18px;
            padding: 10px 0;
        }


        @media(max-width: 299px) {

            .nav-card-selectors {
                display: block
            }
            .nav-card-selector {
                margin-bottom: 17px;
            }
        }

        @media(max-width: 991px) {

            .global-layout {
                padding: 0;
            }
        }
    </style>

    @includeIf(config('slim-dashboard.extra_assets'))
</head>

<body class="font-sans antialiased" x-data="{
        darkmode: $persist(false),
        mobilePage: null,
        isMobile: false,
        isMedium: false,
        cardModal: false,
        bottomNav: true,
        mobileFilterLabel: $persist(''),
        appname: null,
        withTheme: 'light-purple-nav',
        toggleTheme(mode) {
            this.darkmode = !this.darkmode
        },
        calMobile() {
            // Check if screen width is less than or equal to 768px (mobile breakpoint)
            this.isMobile = window.innerWidth <= 991;
        },
        callMedium() {
            this.isMedium = window.innerWidth <= 991;
        }
    }" x-init="mobilePage = '{{ $title ?? '' }}';calMobile()">
    <div class="dashboard-wrapper">
        @php
            $isPreview = $isPreview ?? false;
        @endphp

        @if ($isPreview == false)
        <x-slimer-navigations />
        @endif

        <main class="dashboard-main-content" style="{{ $isPreview ? 'margin-left: 0;' : '' }}">
            <x-slim-dashboard::alerts.system />
            <div class="dashboard-head-section page-heading-section" x-cloak x-show="isMobile==false" id="withGlobalCta">
                <x-slim-dashboard::utils.breadcrumb :data="$breadcrumb ?? []" />
                <x-slim-dashboard::utils.global-cta />
            </div>

            <div class="main-content-wrapper">
                
                <x-slim-dashboard::alerts.session />
                <x-slim-dashboard::alerts.custom />
                
                @if (config('slim-dashboard.inject_view_into_layout.replace'))
                    @includeIf(config('slim-dashboard.inject_view_into_layout.view'))
                @else
                    {{ $slot }}
                    @includeIf(config('slim-dashboard.inject_view_into_layout.view'))
                @endif

            @livewire('slimer::global-modal')
            </div>
        </main>
    </div>

    

    <script>
        if (navigator.userAgent.indexOf('iPhone') > -1) {
            document
                .querySelector("[name=viewport]")
                .setAttribute("content", "width=device-width, initial-scale=1, maximum-scale=1");
        }
    </script>
    @stack('scripts')
</body>

</html>
