<div x-data="{alert: true}">
    @if (session('success-message'))
    <p class="custom-alert-wrapper alert-dark-bg justify-inline-wrapper"
        x-on:success-alert.window="'{{session('success-message')}}'"
        x-show="alert" x-cloak x-transition>
        {{ session('success-message') }}
        <span x-on:click="alert=false" class="as-pointer">
            <x-slim-dashboard::icons.close />
        </span>
    </p>
    @endif

    @if (session()->has('failed'))
    <p class="custom-alert-wrapper error justify-inline-wrapper"
        x-on:success-alert.window="'{{session('failed')}}'"
        x-show="alert" x-cloak>
        {{ session('failed') }}
        <span x-on:click="alert=false"></span>
        <x-slim-dashboard::icons.close />
    </p>
    @endif


    @if (session()->has('success'))
    <p class="success">
        {{ session('success') }}
    </p>
    @endif

    @if (session('password'))
    <div class="success">
        {{ session('password') }}
    </div>
    @endif

    @if (session('record-exist'))
    <div class="error">
        {{ session('record-exist') }}
    </div>
    @endif

    @if (session('proof-id'))
    <div class="error">
        {{ session('proof-id') }}
    </div>
    @endif


</div>
