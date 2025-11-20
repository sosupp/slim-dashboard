<div x-data="{alert: true}">
    @if (session('success-message'))
    <p class="custom-alert-wrapper alert-dark-bg justify-inline-wrapper as-pointer"
        x-on:success-alert.window="'{{session('success-message')}}'"
        x-show="alert" x-cloak x-transition>
        {{ session('success-message') ?? 'Action successful' }}
        <span x-on:click="alert=false" class="alert-closer">
            <x-icons.close />
        </span>
    </p>
    @endif
</div>

<div x-data="{alert: true}">
    @if (session()->has('failed'))
    <p class="custom-alert-wrapper error-dark-theme alert-dark-bg justify-inline-wrapper as-pointer"
        x-on:success-alert.window="'{{session('failed')}}'"
        x-show="alert" x-cloak>
        {{ session('failed') ?? 'Something went wrong' }}
        <span x-on:click="alert=false" class="alert-closer">
            <x-icons.close />
        </span>
    </p>
    @endif
</div>
