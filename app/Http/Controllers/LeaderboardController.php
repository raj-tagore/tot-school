<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyTally;
use Illuminate\Support\Arr;

class LeaderboardController extends Controller
{
    public function index(Request $request) {

        $fieldsToSum = array_keys(config('columns.columns'));

        $selectStatements = array_map(function ($field) {
            return "SUM(`$field`) as `$field`";
        }, $fieldsToSum);

        $selectRaw = implode(', ', $selectStatements);

        $allUsers = DailyTally::select('user_id')
            ->selectRaw($selectRaw)
            ->join('users', 'daily_tallies.user_id', '=', 'users.id')
            ->where('admin', false) 
            ->groupBy('user_id')
            ->with('user') 
            ->get();
            

        return view('leaderboard', ['allUsers' => $allUsers]);
    }

    public function show(Request $request, $key) {
        $fieldsToSum = array_keys(config('columns.columns'));

        $selectStatements = array_map(function ($field) {
            return "SUM(`$field`) as `$field`";
        }, $fieldsToSum);

        $selectRaw = implode(', ', $selectStatements);

        $allUsers = DailyTally::select('user_id')
            ->selectRaw($selectRaw)
            ->join('users', 'daily_tallies.user_id', '=', 'users.id')
            ->where('users.admin', false) 
            ->groupBy('user_id')
            ->with('user') 
            ->get();

        $allUsers = $allUsers->sortByDesc($key);

        return view('specific_leaderboard', ['allUsers' => $allUsers, 'key' => $key]);
    }
}
