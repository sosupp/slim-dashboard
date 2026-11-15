@if ($hasMoreRecords)
    <div class="load-more-wrapper">

        <button
            type="button"
            class="load-more-button"
            wire:click="loadMore(@js($nextRecordsCursor ?? $this->tableRecords->nextCursor()?->encode()))"
            wire:loading.attr="disabled"
            wire:target="loadMore"
        >
            <span wire:loading.remove wire:target="loadMore">
                Load more records
                {{-- <x-slim-dashboard::icons.chevron-down
                    w="17"
                    color="currentColor"
                /> --}}
            </span>

            <span
                wire:loading.flex
                wire:target="loadMore"
                class="load-more-loading"
            >
                <span class="load-more-spinner"></span>
                Loading records...
            </span>
        </button>

    </div>
@endif

<style>
    .load-more-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px 10px 30px;
    }

    .load-more-button {
        min-width: 190px;
        min-height: 44px;
        padding: 10px 20px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;

        border: 1px solid #dce6e1;
        border-radius: 9px;

        background: #fff;
        color: #347571;

        font-size: 13px;
        font-weight: 600;

        cursor: pointer;
        transition: all .2s ease;
    }

    .load-more-button:hover:not(:disabled) {
        background: #f0f7f4;
        border-color: #347571;
    }

    .load-more-button:disabled {
        opacity: .65;
        cursor: wait;
    }

    .load-more-loading {
        display: inline-flex;
        align-items: center;
        gap: 9px;
    }

    .load-more-spinner {
        width: 15px;
        height: 15px;
        border: 2px solid #dce6e1;
        border-top-color: #347571;
        border-radius: 50%;
        animation: load-more-spin .7s linear infinite;
    }

    @keyframes load-more-spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
