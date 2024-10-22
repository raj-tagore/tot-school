<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyTally;
use App\Models\User;
use Carbon\Carbon;
use DatePeriod;
use DateInterval;
use App\Models\CustomSettings;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user_id = auth()->id();
        $user = auth()->user();
        $todaysTally = DailyTally::where('user_id', $user_id)->where('date', Carbon::today())->first();

        $fieldsToSum = array_keys(config('columns.columns'));

        $selectStatements = array_map(function ($field) {
            return "SUM(`$field`) as `$field`";
        }, $fieldsToSum);

        $selectRaw = implode(', ', $selectStatements);

        $totalTally = DailyTally::where('user_id', $user_id)
            ->selectRaw($selectRaw)
            ->first();
        $totalTally = collect($totalTally->toArray());
        $totalTally->put('name', $user->name);

        $count = DailyTally::where('user_id', $user_id)->count();

        if ($todaysTally === null) {
            $todaysTally = collect(config('columns.columns'))->mapWithKeys(function ($item, $key) {
                return [$key => 0];
            });
        }
        
        $userData = DailyTally::where('user_id', $user_id)->get();

        // Weekly data computation
        $startWeek = $user->created_at->startOfWeek();
        $endWeek = Carbon::now()->startOfWeek();
        $weeks = [];
        $period = new DatePeriod($startWeek, new DateInterval('P1W'), $endWeek->addWeek());

        foreach ($period as $date) {
            $weeks[] = $date->format('Y-m-d');
        }
        
        $weeklySums = [];
        foreach ($fieldsToSum as $field) {
            $weeklySums[$field] = array_fill(0, count($weeks), 0);
        }

        $userDataByWeek = $userData->groupBy(function ($item) {
            return Carbon::parse($item->date)->startOfWeek()->format('Y-m-d');
        });

        foreach ($userDataByWeek as $weekStart => $items) {
            $weekIndex = array_search($weekStart, $weeks);
            foreach ($fieldsToSum as $field) {
                $weeklySums[$field][$weekIndex] = $items->sum($field);
            }
        }

        // Monthly data computation
        $joinYear = $user->created_at->year;
        $startMonth = Carbon::create($joinYear, 1, 1); // Start from January of the join year
        $endMonth = Carbon::now()->startOfMonth();
        $months = [];
        $period = new DatePeriod($startMonth, new DateInterval('P1M'), $endMonth->copy()->addMonth());

        foreach ($period as $date) {
            $months[] = $date->format('Y-m-d');
        }

        $monthlySums = [];
        foreach ($fieldsToSum as $field) {
            $monthlySums[$field] = array_fill(0, count($months), 0);
        }

        $userDataByMonth = $userData->groupBy(function ($item) {
            return Carbon::parse($item->date)->startOfMonth()->format('Y-m-d');
        });

        foreach ($userDataByMonth as $monthStart => $items) {
            $monthIndex = array_search($monthStart, $months);
            if ($monthIndex !== false) {
                foreach ($fieldsToSum as $field) {
                    $monthlySums[$field][$monthIndex] = $items->sum($field);
                }
            }
        }

        $monthLabels = array_map(function ($date) {
            return Carbon::parse($date)->format('M Y');
        }, $months);

        // Quaterly data computation
        $startQuarter = Carbon::create($joinYear, 1, 1); // Start from Q1 of the join year
        $endQuarter = Carbon::now()->firstOfQuarter();

        $quarters = [];
        $period = new DatePeriod($startQuarter, new DateInterval('P3M'), $endQuarter->copy()->addMonths(3));

        foreach ($period as $date) {
            $quarters[] = $date->format('Y-m-d');
        }

        $quarterlySums = [];
        foreach ($fieldsToSum as $field) {
            $quarterlySums[$field] = array_fill(0, count($quarters), 0);
        }

        $userDataByQuarter = $userData->groupBy(function ($item) {
            return Carbon::parse($item->date)->firstOfQuarter()->format('Y-m-d');
        });

        foreach ($userDataByQuarter as $quarterStart => $items) {
            $quarterIndex = array_search($quarterStart, $quarters);
            if ($quarterIndex !== false) {
                foreach ($fieldsToSum as $field) {
                    $quarterlySums[$field][$quarterIndex] = $items->sum($field);
                }
            }
        }

        $quarterLabels = array_map(function ($date) {
            $carbonDate = Carbon::parse($date);
            $year = $carbonDate->year;
            $quarter = ceil($carbonDate->month / 3);
            return 'Q' . $quarter . ' ' . $year;
        }, $quarters);

        $zoom_link = CustomSettings::where('name', 'Zoom meeting link')->first();

        // Instead of returning a view, return JSON
        return response()->json([
            'user'            => $user,
            'userData'        => $userData,
            'totalTally'      => $totalTally,
            'todaysTally'     => $todaysTally,
            'count'           => $count,
            'weeks'           => $weeks,
            'weeklySums'      => $weeklySums,
            'monthLabels'     => $monthLabels,
            'monthlySums'     => $monthlySums,
            'quarterLabels'   => $quarterLabels,
            'quarterlySums'   => $quarterlySums,
            'zoom_link'       => $zoom_link,
        ]);
    }

    public function columns() {
        $columns = config('columns.columns');
        return response()->json(['columns' => $columns]);
    }
    
}
