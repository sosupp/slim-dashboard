<div class="admin-sidenav light-purple-nav"
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
        <div class="mobile-page-title" x-cloak x-show="mobilePage!==null && isMobile">
            <p x-text="mobilePage"></p>
        </div>

        <div class="for-mobile">
            <span x-on:click="toggleMenu()" x-show="!open">
                <x-icons.menu class="for-mobile as-pointer" />
            </span>

            <span x-on:click="toggleMenu()" x-show="open">
                <x-icons.close-x />
            </span>
        </div>

        <div x-cloak x-show="mobilePage==null && !isMobile">
            <x-utils.portal.logo route="portal.dashboard.index" />
        </div>


    </div>

    <div class="mobile-menu-overlay" x-show="isMobile ? open : open = true"
        x-on:click="toggleMenu">
        @persist('admin-side-nav')
        <div class="nav-items-wrapper">
            <x-utils.portal.logo route="portal.dashboard.index" />

            @forelse ($navItems as $item)
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

            <x-utils.portal.logout class="logout-wrapper" id="orangeRedButton" />
        </div>
        @endpersist()

        <span class="as-pointer mobile-close-cta" id="rightClose" x-show="isMobile ? open : open = !open" x-cloak>
            <x-icons.close />
        </span>
    </div>

</div>
