<?php
namespace Sosupp\SlimDashboard\Concerns;

trait CalculableTableRecord
{
    public function sumSales($products)
    {
        // dd($products);
        return (collect($products)->sum(function($query){
            return $query->pivot->total_amount;
        }));
    }
}
