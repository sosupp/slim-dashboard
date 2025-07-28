<?php
namespace Sosupp\SlimDashboard\Concerns\Filters;

use Illuminate\Database\Eloquent\Builder;

trait CommonScopes
{
    // Scopes
    public function scopeStatus(Builder $query, string|null $status = null): void
    {
        $query->when($status !== null, function($q) use($status){
            $q->where('status', $status);
        });
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'active');
    }

    public function scopeInactive(Builder $query): void
    {
        $query->orWhere('status', 'inactive');
    }

    public function scopeDated(Builder $query, string|array|null $date = null, string $col = 'created_at'): void
    {
        // dd($date);
        if(!is_null($date)){
            $query->when(is_string($date) && !empty($date) && $date !== null, function($query) use($date, $col){
                $query->whereDate($col, '>=', $date)
                ->whereDate($col, '<=', $date);
            })
            ->when(is_array($date) && !empty($date), function($query) use($date, $col){
                // dd($date);
                $date = collect($date)->reject(function($date){
                    return empty($date) || is_null($date);
                });

                if($date->count() == 1){
                    $query->whereDate($col, '>=', $date)
                    ->whereDate($col, '<=', $date);
                    return;
                }

                $useDate = [
                    $date['start'] . ' 00:00:00',
                    $date['end'] . ' 23:59:59',
                ];


                $query->whereBetween($col, $useDate);
            });
        }
    }



    public function scopeMatchSearch(Builder $query, string $col, string $search): void
    {
        $query->where($col, 'LIKE', $search.'%');
    }

    public function scopeContainSearch(Builder $query, string $col, string $search): void
    {
        $query->where($col, 'LIKE', '%'.$search.'%');
    }

    public function scopeWithSearch(Builder $query, string $type = 'contain', string $col, string $search): void
    {
        if($type === 'contain'){
            $query->where($col, 'LIKE', '%'.$search.'%');
            return;
        }

        if($type === 'match'){
            $query->where($col, 'LIKE', $search.'%');
        }
    }


}
