<?php

namespace Sosupp\SlimDashboard\Livewire\Traits;

trait HandlesLoadMore
{
    public ?string $nextRecordsCursor = null;

    public bool $hasMoreRecords = true;

    public function loadMore(): void
    {
        if (! $this->hasMoreRecords) {
            return;
        }

        $cursor = $this->nextRecordsCursor
        ? \Illuminate\Pagination\Cursor::fromEncoded($this->nextRecordsCursor)
        : null;

        $paginator = $this->tableRecords;

        $records = $paginator->items();

        if (empty($records)) {
            $this->hasMoreRecords = false;
            return;
        }

        $html = view(
            'slim-dashboard::includes.table.mobile.load-more-records',
            ['records' => $records]
        )->render();

        $this->stream(
            to: 'table-records',
            content: $html,
            replace: false
        );

        $this->nextRecordsCursor = $paginator->nextCursor()?->encode();

        $this->hasMoreRecords = $paginator->hasMorePages();
    }
}