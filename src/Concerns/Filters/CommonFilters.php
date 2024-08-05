<?php
namespace Sosupp\SlimDashboard\Concerns\Filters;

trait CommonFilters
{
    protected $recordLimit = 12;
    protected $easyFilter;

    protected $inActive = false;
    protected $active = true;

    protected $searchType = 'search';
    protected $searchTerm = '';
    protected $searchCol = '';

    protected $orderByDirection = 'asc';
    protected $orderByColumn = 'created_at';

    public function limit(int $qty = 12)
    {
        $this->recordLimit = $qty;
        // $this->products->limit($qty);
        // dd($qty, $this->recordLimit, $this->products->get());
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
        // dd("yes");
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

    public function orderBy(string $direction = 'asc', string $col = 'created_at')
    {
        $this->orderByDirection = $direction;
        $this->orderByColumn = $col;

        return $this;
    }
}
