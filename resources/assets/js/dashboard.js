document.addEventListener('alpine:init', () => {
    Alpine.data('accordion', () => ({
        isOpen: window.innerWidth >= 768,
        toggleKey: null,
        toggle(key = null) {
            if (key == null) {
                this.isOpen = !this.isOpen;
                console.log('no key');
                return;
            }

            this.toggleKey = key;
            if (key == this.toggleKey) {
                console.log('key', key, this.toggleKey);
                return this.isOpen = !this.isOpen;
            }

        },
        checkWidth() {
            this.isOpen = window.innerWidth >= 768;
        }
    }))

    Alpine.data('sidepanel', (wire) => ({
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
            if(record !== null){
                this.$wire.sidePanelModel(record)
                this.$wire.resolvePanelModel(record)
            }
        },
        closePanel(){
            this.sidePanel = !this.sidePanel
            this.$dispatch('closesidepanel')
        },
        updateDate(selector) {
            let useValue = document.getElementById(selector).value;
            if (!useValue) return;

            let date = new Date(useValue);
            let month = ('0' + (date.getMonth() + 1)).slice(-2);
            let year = date.getFullYear();
            this.dateValue = `${year}-${month}`;
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

    Alpine.data('chartManager', (data) => ({
        chartsData: data,
        chartInstances: {},

        init() {

            // Initial render (wait for DOM)
            this.$nextTick(() => this.renderAllCharts());

            // Watch for changes in chartsData
            this.$watch('chartsData', (newVal) => {
                this.renderAllCharts();
            });
        },

        normalize(value) {
            if (Array.isArray(value)) return value;
            if (value == null) return [];

            if (typeof value === 'object') {
                // Livewire sometimes ships arrays as keyed objects: {0:{},1:{}}
                return Object.values(value);
            }

            if (typeof value === 'string') {
                try { return JSON.parse(value); } catch (e) { return []; }
            }

            return [];
        },

        createChart(canvasId, labels, data, color) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            return new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: color,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    animation: { duration: 1200, easing: 'easeOutQuart' },
                    scales: {
                        y: { position: 'right', beginAtZero: true },
                        x: { grid: { display: false } }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        },

        renderAllCharts() {
            const items = this.normalize(this.chartsData);
            // Destroy old charts
            for (const key in this.chartInstances) {
                this.chartInstances[key]?.destroy?.();
            }

            this.chartInstances = {};

            // Create fresh charts
            items.forEach(chart => {
                const id = `${chart.key}Chart`;
                const ctx = document.getElementById(id)?.getContext('2d');
                if (!ctx) return;

                this.chartInstances[id] = new Chart(ctx, {
                    type: chart.type || 'bar',
                    data: {
                        labels: chart.labels || [],
                        datasets: [{
                            data: chart.data || [],
                            backgroundColor: chart.color || 'rgba(75, 192, 192, 0.7)',
                            borderRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        animation: { duration: 1200, easing: 'easeOutQuart' },
                        scales: {
                            y: { position: 'right', beginAtZero: true },
                            x: { grid: { display: false } }
                        },
                        plugins: { legend: { display: false } }
                    }
                });
            });
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
