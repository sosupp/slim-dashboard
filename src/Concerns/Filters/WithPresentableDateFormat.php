<?php
namespace Sosupp\SlimDashboard\Concerns\Filters;

use DateTime;
use Illuminate\Support\Carbon;

trait WithPresentableDateFormat
{
    public function easyDates($key)
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
        ][$key];
    }

    public function prettyDate(string|array $date)
    {

        // dd($date);

        if(is_array($date)){
            return $this->pretifyArrayDates($date);
        }

        // $format =  $this->easyDates($date);
        $formatDate = $this->easyDates($date);

        if(is_array($formatDate)){
            return $this->pretifyArrayDates($formatDate);
        }

        $dateFormat = new DateTime($formatDate);
        return $dateFormat->format('M d, Y');


    }

    public function pretifyArrayDates(array $date)
    {
        $items = collect($date)->reject(function($date){
            return empty($date) || is_null($date);
        })->map(function($date){
            return (new DateTime($date))->format('M d, Y');
        });

        // dd($items);
        return $items->implode(' to ');
    }

    public function simplePrettyDate(string $date)
    {
        $dateFormat = new DateTime($date);
        return $dateFormat->format('M d, Y');
    }

    public function yearMonth(string|array $date = 'this month', string $format = 'M-Y')
    {
        $result = $this->easyDates($date);

        // dd($result);
        if(is_array($result)){
            // dd($date);
            $dateFormat = new DateTime($result['start']);
            return $dateFormat->format($format);
        }

        $dateFormat = new DateTime($result);
        return $dateFormat->format($format);
    }
}
