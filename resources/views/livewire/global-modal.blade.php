<div x-data="{
    modal: false,
    title: '',
    toggleModal(data = null){
        this.modal = !this.modal;
        this.title = data?.title;
        if(data !==null){
            console.log('calling', data.component, data.title);
            $dispatch('switch-modal', {
                component: data.component,
            })
        }
    },
    closeModal(){
        this.modal = false;
    }
}"
x-on:globalmodal.window="toggleModal($event.detail)"

x-on:closeglobalmodal.window="closeModal()"
x-show="modal" x-cloak
    >

    <div class="global-modal-panel">
        <div class="global-modal-heading-wrapper">
            <p x-html="title"></p>
        </div>

        <div class="global-modal-content">
            <div class="dashboard-errors-wrapper">
                @forelse ($errors->all() as $message)
                    <p class="error">{{$message}}</p>
                @empty

                @endforelse
            </div>

            @if (isset($componentName) && !empty($componentName))
                @livewire($componentName, $this->passExtraData(), key($componentName))
            @else
            @includeIf($this->useViewFile, $this->passExtraData())
            @endif
        </div>
    </div>

    <div class="global-modal-overlay" x-on:click.self="closeModal()"></div>
</div>
