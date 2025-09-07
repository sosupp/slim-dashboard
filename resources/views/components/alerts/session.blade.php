<div x-data="{alert: true}">
    @if (session('success-message'))
    <p class="custom-alert-wrapper alert-dark-bg justify-inline-wrapper"
        x-on:success-alert.window="'{{session('success-message')}}'"
        x-show="alert" x-cloak x-transition>
        {{ session('success-message') ?? 'Message' }}
        <span x-on:click="alert=false" class="as-pointer">
            <x-icons.close />
        </span>
    </p>
    @endif
</div>

<div x-data="{alert: true}"> 
    @if (session()->has('failed'))
    <p class="custom-alert-wrapper error-dark-theme justify-inline-wrapper"
        x-on:success-alert.window="'{{session('failed')}}'"
        x-show="alert" x-cloak>
        {{ session('failed') ?? 'Message' }}
        <span x-on:click="alert=false"></span>
        <x-icons.close />
    </p>
    @endif


</div>
