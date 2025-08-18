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
        <x-slimer-navigations />

        <main class="dashboard-main-content">
            <div class="dashboard-head-section page-heading-section" x-cloak x-show="isMobile==false" id="withGlobalCta">
                <x-slim-dashboard::utils.breadcrumb :data="$breadcrumb ?? []" />
            </div>

            <div class="main-content-wrapper">
                <x-slim-dashboard::alerts.session />
                <x-slim-dashboard::alerts.custom />
                {{ $slot }}
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
