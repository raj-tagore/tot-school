<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ViewRecord;
use App\Models\DailyTally;
use App\Models\User;
use App\Models\CustomSettings;
use Carbon\Carbon; // For handling date operations
use DatePeriod;
use DateInterval;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public static string $view = 'dashboard';

    protected function getViewData(): array
    {
        $user = $this->record;
        $userDashboardData = $this->getUserDashboardData($user);

        $zoom_link = CustomSettings::where('name', 'Zoom meeting link')->first();

        return [
            'user' => $user,
            'todaysTally' => $userDashboardData['todaysTally'],
            'totalTally' => $userDashboardData['totalTally'],
            'count' => $userDashboardData['count'],
            'weeklySums' => $userDashboardData['weeklySums'],
            'weeks' => $userDashboardData['weeks'],
            'monthlySums' => $userDashboardData['monthlySums'],
            'monthLabels' => $userDashboardData['monthLabels'],
            'quarterlySums' => $userDashboardData['quarterlySums'],
            'quarterLabels' => $userDashboardData['quarterLabels'],
            'zoom_link' => $zoom_link,
            'thisYearsTotal'  => $userDashboardData['thisYearsTotal'],
            'lastYearsTotal'  => $userDashboardData['lastYearsTotal'],
        ];
    }

    protected function getUserDashboardData($user) {

        $user_id = $user->id;
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

        // 4. Get this year's total (for 2025)
        $thisYearsTotal = DailyTally::where('user_id', $user_id)
            ->whereYear('date', 2025)
            ->selectRaw($selectRaw)
            ->first();
        // Handle the case if it's null
        if (!$thisYearsTotal) {
            // If no record, fill with zeros
            $thisYearsTotal = array_fill_keys($fieldsToSum, 0);
        } else {
            // Convert to collection
            $thisYearsTotal = collect($thisYearsTotal->toArray());
        }

        // 5. Get last year's total (for 2024)
        $lastYearsTotal = DailyTally::where('user_id', $user_id)
            ->whereYear('date', 2024)
            ->selectRaw($selectRaw)
            ->first();
        if (!$lastYearsTotal) {
            $lastYearsTotal = array_fill_keys($fieldsToSum, 0);
        } else {
            $lastYearsTotal = collect($lastYearsTotal->toArray());
        }

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

        return [
            'todaysTally' => $todaysTally,
            'totalTally' => $totalTally,
            'count' => $count,
            'weeklySums' => $weeklySums,
            'weeks' => $weeks,
            'monthlySums' => $monthlySums,
            'monthLabels' => $monthLabels,
            'quarterlySums' => $quarterlySums,
            'quarterLabels' => $quarterLabels,
            'thisYearsTotal' => $thisYearsTotal,
            'lastYearsTotal' => $lastYearsTotal,
        ];

    }
}
