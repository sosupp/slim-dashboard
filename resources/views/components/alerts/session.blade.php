<div x-data="{alert: true}">
    @if (session('success-message'))
    <p class="custom-alert-wrapper success-dark-theme"
        x-on:success-alert.window="'{{session('success-message')}}'"
        x-show="alert" x-cloak x-transition>
        {{ session('success-message') ?? 'Message' }}
        <span x-on:click="alert=false" class="as-pointer">
        </span>
        <x-slim-dashboard::icons.close />
    </p>
    @endif

    @if (session()->has('failed'))
    <p class="custom-alert-wrapper error-dark-theme"
        x-on:success-alert.window="'{{session('failed')}}'"
        x-show="alert" x-cloak>
        {{ session('failed') ?? 'Message' }}
        <span x-on:click="alert=false"></span>
        <x-slim-dashboard::icons.close />
    </p>
    @endif


</div>
