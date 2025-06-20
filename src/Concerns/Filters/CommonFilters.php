<?php
namespace Sosupp\SlimDashboard\Concerns\Filters;

trait CommonFilters
{
    protected $recordLimit = 12;
    protected $easyFilter;

    protected $inActive = false;
    protected $active = true;
    protected $status = null;
    protected $statusCol = 'status';

    protected $withTrashed = false;
    protected $withoutRelation = null;
    protected $withoutRelationCol = null;
    protected $withoutRelationColValue = null;

    protected $searchType = 'containSearch';
    protected $searchTerm = '';
    protected $searchCol = '';

    protected $orderByDirection = 'asc';
    protected $orderByColumn = 'created_at';

    protected $selectedDate = [];
    protected $selectedDateColumn = 'created_at';

    public function limit(int $qty = 12)
    {
        $this->recordLimit = $qty;
        return $this;
    }

    public function date(string|array|null $date = null, string $col = 'created_at')
    {
        $this->selectedDate = $date;
        $this->selectedDateColumn = $col;
        return $this;
    }

    public function search(string $term = '', string $col = 'name')
    {
        $this->searchTerm = $term;
        $this->searchCol = $col;
        return $this;
    }

    public function matchSearch(string $term = '', string $col = 'name')
    {
        $this->searchType = 'matchSearch';
        $this->searchCol = $col;
        $this->searchTerm = $term;
        return $this;
    }

    public function containSearch(string $term = '', string $col = 'name')
    {
        $this->searchType = 'containSearch';
        $this->searchCol = $col;
        $this->searchTerm = $term;
        return $this;
    }

    public function withInactive()
    {
        $this->inActive = true;
        return $this;
    }

    public function active()
    {
        $this->active = true;
        $this->status = 'active';
        return $this;
    }

    public function withActive(string $column = 'status', string|bool $status = 'active')
    {
        $this->active = true;
        $this->status = $status;
        $this->statusCol = $column;
        return $this;
    }

    public function orderBy(string $direction = 'asc', string $col = 'created_at')
    {
        $this->orderByDirection = $direction;
        $this->orderByColumn = $col;

        return $this;
    }

    public function withTrashed()
    {
        $this->withTrashed = true;
        return $this;
    }

    public function withoutTrashed()
    {
        $this->withTrashed = false;
        return $this;
    }

    public function without(array $colValues, string $col, string $relation)
    {
        $this->withoutRelation = $relation;
        $this->withoutRelationCol = $col;
        $this->withoutRelationColValue = $colValues;
        return $this;
    }
}
