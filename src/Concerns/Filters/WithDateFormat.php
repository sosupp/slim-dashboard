<?php
namespace Sosupp\SlimDashboard\Concerns\Filters;

use Illuminate\Support\Carbon;

trait WithDateFormat
{
    protected $selectedDate = [];
    protected $selectedDateEnd;
    protected $dateColumn = 'created_at';

    public function forDate(string|array $date = 'today', string $dateColumn = 'created_at')
    {
        // dd($date);
        $this->dateColumn = $dateColumn;

        if(is_array($date)){
            $this->selectedDate = $date;
            return $this;
        }

        // dd($date);
        $this->selectedDate = $this->formatDates($date);
        // dd($date, $this->selectedDate);
        return $this;
    }

    private function formatDates($key)
    {
        return [
            'today' => Carbon::today()->format('Y-m-d'),
            'yesterday' => Carbon::yesterday()->format('Y-m-d'),
            'this week' => [
                'start' => Carbon::today()->startOfWeek()->format('Y-m-d'),
                'end' => Carbon::today()->endOfWeek()->format('Y-m-d')
            ],
            'last week' => [
                'start' => Carbon::today()->startOfWeek()->subDays(7),
                'end' => Carbon::today()->startOfWeek()->subDays(1)
            ],
            'this month' => [
                'start' => Carbon::today()->startOfMonth()->format('Y-m-d'),
                'end' => Carbon::today()->endOfMonth()->format('Y-m-d')
            ],
            'last month' => [
                'start' => Carbon::today()->startOfMonth()->subMonth()->format('Y-m-d'),
                'end' => Carbon::today()->startOfMonth()->subDays(1)->format('Y-m-d')
            ],
            'this year' => [
                'start' => Carbon::today()->startOfYear()->format('Y-m-d'),
                'end' => Carbon::today()->endOfYear()->format('Y-m-d')
            ],
            'last year' => [
                'start' => Carbon::today()->startOfYear()->subYear()->format('Y-m-d'),
                'end' => Carbon::today()->startOfYear()->subDays(1)->format('Y-m-d')
            ],
            'all time' => null
        ][$key];
    }

    private function configureDateRanges($query)
    {
        // dd($query, $date);
        $date = collect($this->selectedDate)->reject(function($date){
            return empty($date) || is_null($date);
        });

        if($date->count() == 1){
            $query->whereDate('created_at', '=', $date);
            return;
        }

        $useDate = [
            $this->selectedDate['start'] . ' 00:00:00',
            $this->selectedDate['end'] . ' 23:59:59',
        ];


        $query->whereBetween('created_at', $useDate);
    }

}
