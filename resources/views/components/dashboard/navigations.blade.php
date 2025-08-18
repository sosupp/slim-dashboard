<div class="{{isset($navItems['css']) ? $navItems['css']['wrapper'] : 'admin-sidenav'}} {{isset($navItems['css']) ? $navItems['css']['bg'] : 'light-purple-nav'}}"
    x-cloak
    x-data="{
        open: false,
        nav: $persist(''),
        toggleMenu(){
            this.open = !this.open
        },
        toggleActive(nav){
            this.nav = nav
        }
    }" x-init="$store.nav"
>

    <div class="logo-section">


        <div class="for-mobile for-medium">
            <span x-on:click="toggleMenu()" x-show="!open">
                <x-slim-dashboard::icons.menu class="for-mobile for-medium as-pointer" />
            </span>

            <span x-on:click="toggleMenu()" x-show="open">
                <x-slim-dashboard::icons.close-x />
            </span>
        </div>

        <div class="mobile-page-title" x-cloak x-show="mobilePage!==null && isMobile">
            <p x-text="mobilePage"></p>
        </div>


        {{-- {{$navItems['logo']['name']}} --}}
        @if (isset($navItems['logo']))
        <div x-cloak x-show="mobilePage==null && !isMobile">
            {!! $navItems['logo']['view'] !!}
        </div>
        @endif
        <span class="leave-empty"></span>
        @if (isset($navItems['action']))
        <div class="quick-links-wrapper" id="globalActionsCta">
            <x-dropdown wrapperCss="" dropdownCss="reset-dropdown">
                <x-slot:trigger>
                    <xx-slim-dashboard::icons.circle-plus w="45" class="as-pointer" />
                </x-slot:trigger>

                <x-slot:content>
                    <div class="quick-transactions">
                        @forelse ($navItems['action'] as $cta)
                        <a class="quick-link-item" wire:navigate href="{{$cta['route']}}">{{$cta['name']}}</a>
                        @empty
                            No global action links
                        @endforelse

                    </div>
                </x-slot:content>
            </x-dropdown>
        </div>
        @endif

    </div>

    <div class="mobile-menu-overlay" x-show="isMobile ? open : open = true"
        x-on:click="toggleMenu">
        @persist('admin-side-nav')
        <div class="nav-items-wrapper">
            <div class="brand-logo-wrapper">
                @if (isset($navItems['logo']))
                {!! $navItems['logo']['view'] !!}
                @endif
            </div>

            @forelse ($navItems['menu'] as $item)
                @if ($item['authorize'])
                <a href="{{!empty($item['url']) ? $item['url'] : '#'}}"
                    wire:navigate
                    class="nav-item"
                    :class="nav == '{{$item['key']}}' ? 'is-active' : ''"
                    x-on:click="toggleActive('{{$item['key']}}')"
                    >

                    <div class="menu-name-and-icon">
                        {!! $item['icon'] !!}

                        {{$item['name']}}
                    </div>

                </a>
                @endif
            @empty
                No nav items
            @endforelse

            @if (isset($navItems['extraView']) && $navItems['extraView']['authorize'])
            <div class="external-view-menu-items">
                {!! $navItems['extraView']['view'] !!}
            </div>
            @endif

            @if (isset($navItems['logout']))
            <form action="{{$navItems['logout']['route']}}" method="POST" class="logout-wrapper">
                @csrf
                <button id="orangeRedButton" type="submit">
                    {{$navItems['logout']['name']}}
                </button>
            </form>
            @endif


        </div>
        @endpersist()

        <span class="as-pointer mobile-close-cta" id="rightClose" x-show="isMobile ? open : open = !open" x-cloak>
            <x-slim-dashboard::icons.close />
        </span>
    </div>
</div>
