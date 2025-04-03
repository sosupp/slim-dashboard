document.addEventListener('alpine:init', () => {
    Alpine.data('accordion', () => ({
        isOpen: window.innerWidth >= 768,
        toggle() {
            this.isOpen = !this.isOpen;
        },
        checkWidth() {
            this.isOpen = window.innerWidth >= 768;
        }
    }))

    Alpine.data('sidepanel', () => ({
        sidePanel: '',
        sidePanelTitle: '',
        useComponent: false,
        componentName: '',
        dateLabel: '',
        toggleSidePanel(component = '', title = '', record = null) {
            console.log('yes panrel')
            this.sidePanelTitle = title
            this.sidePanel = !this.sidePanel
            if(component !== ''){
                this.useComponent = true
                this.componentName = component
            }else {
                this.useComponent = false
            }
            if(record !== null){
                $wire.sidePanelModel(record)
                $wire.resolvePanelModel(record)
                console.log(record)
            }
        },
        closePanel(){
            this.sidePanel = !this.sidePanel
        }
    }))

    Alpine.data('image', () => ({
        imgsrc: null,
        modelImageId: '',
        previewImage(modelId) {

            this.modelImageId = modelId;
            let file = this.$refs.uploadedImage.files[0];
            let filename = file.name;

            let form = document.getElementById('imageForm')
            if (!file || file.type.indexOf('image/') === -1) return;
            this.imgsrc = null;

            let reader = new FileReader();

            reader.onload = e => {
                this.imgsrc = e.target.result;
            }

            reader.readAsDataURL(file);
            console.log('yes image')
        }
    }))

    // Listen to window resize globally
    window.addEventListener('resize', () => {
        document.querySelectorAll('[x-data="accordion()"]').forEach(el => {
            Alpine.data('accordion').call(el).__x.$data.checkWidth();
        });
    });
})
