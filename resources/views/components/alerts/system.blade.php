<div x-data="{alert: true}">
    @if (session()->has('system'))
    <p class="system-error-banner justify-inline-wrapper"
        x-on:success-alert.window="'{{session('system')}}'"
        x-show="alert" x-cloak x-transition>
        {{ session('system') }}
        <span x-on:click="alert=false" class="as-pointer">
            <x-slim-dashboard::icons.close />
        </span>
    </p>
    @endif

    @if (session('renew'))
    <div class="system-alert-banner alert-dark-bg justify-inline-wrapper"
        x-on:success-alert.window="''"
        x-show="alert" x-cloak x-transition>

        <div class="inline-together">

            {{ session('renew') }}

            <a href="{{route('platform.systems.page')}}"
                class="renew-cta">RENEW NOW</a>
        </div>


        <span x-on:click="alert=false" class="as-pointer">
            <x-slim-dashboard::icons.close />
        </span>
    </div>
    @endif
</div>
