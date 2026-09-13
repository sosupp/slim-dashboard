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
        panelAsModal: false,
        useComponent: false,
        componentName: '',
        dateLabel: '',
        hasCustomDate: false,
        toggleSidePanel(component = '', title = '', record = null, asModal = false) {
            console.log('panrel page')
            this.sidePanelTitle = title
            this.sidePanel = !this.sidePanel

            if (component !== '') {
                if(asModal){
                    this.panelAsModal = true;
                }

                this.useComponent = true
                this.componentName = component
                this.$wire.setSidePanelComponent(component)

            }else {
                this.useComponent = false
                this.$wire.clearSidePanelComponent()
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

    // Reusable Stepper Component using Alpine.js
    Alpine.data('stepper', (config = {}) => {
        return {
            // Configuration
            steps: config.steps || [],
            currentStep: config.initialStep || 0,
            allowSkip: config.allowSkip || false,
            orientation: config.orientation || 'horizontal',
            validateStep: config.validateStep || null,
            onStepChange: config.onStepChange || null,
            onComplete: config.onComplete || null,

            // State
            completedSteps: [],
            stepStatus: {},
            isTransitioning: false,

            // Computed
            get totalSteps() {
                return this.steps.length;
            },

            get isFirstStep() {
                return this.currentStep === 0;
            },

            get isLastStep() {
                return this.currentStep === this.totalSteps - 1;
            },

            get progress() {
                return ((this.currentStep + 1) / this.totalSteps) * 100;
            },

            get currentStepData() {
                return this.steps[this.currentStep] || {};
            },

            get stepStatusList() {
                return this.steps.map((step, index) => ({
                    ...step,
                    index,
                    status: this.getStepStatus(index),
                    isActive: index === this.currentStep,
                    isCompleted: this.isStepCompleted(index),
                    isCurrent: index === this.currentStep,
                }));
            },

            // Methods
            init() {
                // Initialize step status
                this.steps.forEach((step, index) => {
                    this.stepStatus[index] = {
                        completed: false,
                        visited: false,
                        valid: true,
                        errors: [],
                    };
                });

                // Mark first step as visited
                this.markStepVisited(0);

                // Emit initialized event
                this.$dispatch('stepper-initialized', {
                    currentStep: this.currentStep,
                    totalSteps: this.totalSteps,
                });
            },

            goToStep(index) {
                if (this.isTransitioning) return;
                if (index < 0 || index >= this.totalSteps) return;
                if (!this.allowSkip && index > this.currentStep + 1) return;
                if (index < this.currentStep && !this.isStepCompleted(index)) return;

                this.isTransitioning = true;

                // Validate before moving forward
                if (index > this.currentStep) {
                    const isValid = this.validateCurrentStep();
                    if (!isValid) {
                        this.isTransitioning = false;
                        return;
                    }
                }

                this.currentStep = index;
                this.markStepVisited(index);

                if (this.onStepChange) {
                    this.onStepChange(index, this.steps[index]);
                }

                this.$dispatch('stepper-step-change', {
                    currentStep: index,
                    stepData: this.steps[index],
                });

                setTimeout(() => {
                    this.isTransitioning = false;
                }, 300);
            },

            nextStep() {
                if (this.isLastStep) {
                    this.complete();
                    return;
                }

                const isValid = this.validateCurrentStep();
                if (!isValid) return;

                this.markStepCompleted(this.currentStep);
                this.goToStep(this.currentStep + 1);
            },

            previousStep() {
                if (this.isFirstStep) return;
                this.goToStep(this.currentStep - 1);
            },

            complete() {
                // Validate all steps
                let allValid = true;
                this.steps.forEach((step, index) => {
                    if (!this.isStepCompleted(index)) {
                        const isValid = this.validateStep ? this.validateStep(index, step) : true;
                        if (!isValid) {
                            allValid = false;
                            this.stepStatus[index].valid = false;
                        }
                    }
                });

                if (!allValid) {
                    this.$dispatch('stepper-validation-failed', {
                        errors: this.getValidationErrors(),
                    });
                    return;
                }

                if (this.onComplete) {
                    this.onComplete();
                }

                this.$dispatch('stepper-completed', {
                    steps: this.steps,
                    completedSteps: this.completedSteps,
                });
            },

            validateCurrentStep() {
                if (!this.validateStep) return true;

                const isValid = this.validateStep(this.currentStep, this.steps[this.currentStep]);
                this.stepStatus[this.currentStep].valid = isValid;
                this.stepStatus[this.currentStep].errors = isValid ? [] : ['Step validation failed'];

                if (!isValid) {
                    this.$dispatch('stepper-validation-error', {
                        step: this.currentStep,
                        errors: this.stepStatus[this.currentStep].errors,
                    });
                }

                return isValid;
            },

            markStepCompleted(index) {
                if (this.isStepCompleted(index)) return;
                this.stepStatus[index].completed = true;
                this.completedSteps.push(index);
                this.$dispatch('stepper-step-completed', {
                    step: index,
                    stepData: this.steps[index],
                });
            },

            markStepVisited(index) {
                this.stepStatus[index].visited = true;
                this.$dispatch('stepper-step-visited', {
                    step: index,
                    stepData: this.steps[index],
                });
            },

            isStepCompleted(index) {
                return this.stepStatus[index]?.completed || false;
            },

            getStepStatus(index) {
                const status = this.stepStatus[index] || {};
                if (status.completed) return 'completed';
                if (status.visited && index === this.currentStep) return 'current';
                if (status.visited) return 'visited';
                return 'pending';
            },

            getValidationErrors() {
                const errors = {};
                this.steps.forEach((step, index) => {
                    if (!this.stepStatus[index].valid) {
                        errors[index] = this.stepStatus[index].errors;
                    }
                });
                return errors;
            },

            resetStepper() {
                this.currentStep = 0;
                this.completedSteps = [];
                this.stepStatus = {};
                this.steps.forEach((step, index) => {
                    this.stepStatus[index] = {
                        completed: false,
                        visited: false,
                        valid: true,
                        errors: [],
                    };
                });
                this.markStepVisited(0);
                this.$dispatch('stepper-reset');
            },
        };
    });
    
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
