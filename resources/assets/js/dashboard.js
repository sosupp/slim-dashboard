document.addEventListener('alpine:init', () => {
    Alpine.data('accordion', () => ({
        isOpen: false,
        toggle() {
            this.isOpen = !this.isOpen;
        },
        checkWidth() {
            this.isOpen = window.innerWidth >= 768;
        }
    }))

    Alpine.data('sidepanel', (useWire) => ({
        sidePanel: '',
        panelWidth: '',
        sidePanelTitle: '',
        useComponent: false,
        componentName: '',
        dateLabel: '',
        toggleSidePanel(component = '', title = '', record = null) {
            console.log('yes panrel')
            this.sidePanelTitle = title
            this.sidePanel = !this.sidePanel
            if(component !== ''){
                this.useComponent = true;
                this.componentName = component;
                this.$wire.$set('sidePanelComponent', component);
            }else {
                this.useComponent = false
            }

            if (record !== null) {
                console.log(record, useWire);
                this.$wire.sidePanelModel(record)
                this.$wire.resolvePanelModel(record)
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

    window.objectToArray = (obj) => {
        if (Array.isArray(obj)) return obj;
        if (obj == null) return [];

        if (typeof obj === 'object') {
            // Livewire sometimes ships arrays as keyed objects: {0:{},1:{}}
            return Object.values(obj);
        }

        if (typeof obj === 'string') {
            try { return JSON.parse(obj); } catch (e) { return []; }
        }

        return [];
    };
})
