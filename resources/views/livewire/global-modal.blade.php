<div x-data="{
    modal: false,
    title: '',
    html: '',
    toggleModal(data = null){
        this.modal = !this.modal;
        this.title = data?.title;
        console.log('from-global', data)
        if(data !==null){
            if(data.render){
                this.html = data.render;
                return;
            }

            console.log('calling', data.component, data.title);
            this.html = '';
            $dispatch('switch-modal', {
                component: data.component,
                model: data.model,
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
    class="global-modal-parent">

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

            <div x-html="html"></div>

            <div x-show="html == ''" x-cloak>
                @if (isset($componentName) && !empty($componentName))
                    @livewire($componentName, $this->passExtraData(), key($componentName))
                @else
                @includeIf($this->useViewFile, $this->passExtraData())
                @endif
            </div>
        </div>
    </div>

    <div class="global-modal-overlay" x-on:click.self="closeModal()"></div>
</div>
