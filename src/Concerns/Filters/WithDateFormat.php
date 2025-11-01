<?php
namespace Sosupp\SlimDashboard\Concerns\Filters;

use Illuminate\Support\Carbon;

trait WithDateFormat
{
    protected $selectedDate = [];
    protected $selectedDateEnd;
    protected $dateColumn = 'created_at';

    public function forDate(string|array|null $date = 'today', string $dateColumn = 'created_at')
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
            'today' => [
                'start' => Carbon::today()->startOfDay()->format('Y-m-d'),
                'start' => Carbon::today()->startOfDay()->format('Y-m-d'),
            ],
            'yesterday' => [
                'start' => Carbon::yesterday()->startOfDay()->format('Y-m-d'),
                'start' => Carbon::yesterday()->startOfDay()->format('Y-m-d'),
            ],
            'this week' => [
                'start' => Carbon::today()->startOfWeek()->format('Y-m-d'),
                'end' => Carbon::today()->endOfWeek()->format('Y-m-d')
            ],
            'last week' => [
                'start' => Carbon::today()->startOfWeek()->subDays(7)->format('Y-m-d'),
                'end' => Carbon::today()->startOfWeek()->subDays(1)->format('Y-m-d')
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
            'all time' => null,
            "" => null
        ][$key];
    }

    private function configureDateRanges($query, string $dateCol = 'created_at')
    {
        // dump($dateCol, $this->selectedDate);
        $date = collect($this->selectedDate)->reject(function($date){
            return empty($date) || is_null($date);
        });

        if($date->count() == 1){
            $query->whereDate($dateCol, '=', $date);
            return;
        }

        $useDate = [
            $this->selectedDate['start'] . ' 00:00:00',
            $this->selectedDate['end'] . ' 23:59:59',
        ];

        // dump($dateCol, $this->selectedDate, $useDate);
        $query->whereBetween($dateCol, $useDate);
    }

    private function prepareDateRanges(array|string $date)
    {
        if(is_null($date)){
            return;
        }
        
        $date = collect($this->selectedDate)->reject(function($date){
            return empty($date) || is_null($date);
        });

        // dd($date);

        if($date->count() == 1){
            return [
                'start' => $date['start'] . ' 00:00:00',
                'end' => $date['start'] . ' 23:59:59',
            ];
        }

        return [
            'start' => $date['start'] . ' 00:00:00',
            'end' => $date['end'] . ' 23:59:59',
        ];
    }

    
    private function excludeStartDate($query, string $dateCol = 'created_at')
    {
        $date = collect($this->selectedDate)->reject(function($date){
            return empty($date) || is_null($date);
        });


        // dd($this->selectedDate, $date, $date['start'], $this->dateColumn);
        if($date->count() == 1){
            $query->whereDate($dateCol, '<', $date['start']);
            return;
        }

        $useDate = $date['start'] . ' 00:00:00';

        $query->whereDate($dateCol, '<', $useDate);
    }

    private function fromEndDate($query, string $dateCol = 'created_at')
    {
        $date = collect($this->selectedDate)->reject(function($date){
            return empty($date) || is_null($date);
        });

        // dd($this->selectedDate, $date, $date['start']);

        if($date->count() == 1){
            $query->whereDate($dateCol, '<=', $date['start']);
            return;
        }

        $useDate = $date['end'] . ' 23:59:59';

        $query->whereDate($dateCol, '<', $useDate);
    }

}
