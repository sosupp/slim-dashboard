<div
    x-data="{
        show: false,
        type: '',
        message: '',
        timeout: null,
        duration: 3000,
        progress: 100,
        startCountdown() {
            this.progress = 100;
            let interval = this.duration / 100; // Progress interval
            this.timeout = setInterval(() => {
                this.progress -= 1;
                if (this.progress <= 0) {
                    clearInterval(this.timeout);
                    this.show = false;
                }
            }, interval);
        }
    }"
    x-on:custom-alert.window="
        type = $event.detail.type;
        message = $event.detail.message;
        show = true;
        startCountdown();
    "
    x-show="show"
    x-transition
    class="custom-alert-wrapper justify-inline-wrapper"
    :class="{
        'success-bg': type == 'success',
        'error-bg': type == 'error'
    }"
    x-cloak
>
    <p x-text="message"></p>

    <div class="countdown-ring">
        <svg class="countdown-svg" viewBox="0 0 36 36">
            <circle
                class="countdown-bg"
                stroke-width="3"
                stroke="currentColor"
                fill="transparent"
                r="16"
                cx="18"
                cy="18"
            ></circle>
            <circle
                class="countdown-progress"
                stroke-width="3"
                :stroke-dasharray="100"
                :stroke-dashoffset="progress"
                stroke-linecap="round"
                stroke="currentColor"
                fill="transparent"
                r="16"
                cx="18"
                cy="18"
            ></circle>
        </svg>
    </div>
</div>
