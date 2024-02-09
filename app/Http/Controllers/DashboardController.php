<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\DailyTally;
use App\Models\TotalTally;
use App\Models\User;
use Carbon\Carbon; // For handling date operations

class DashboardController extends Controller
{
    public function index(Request $request) {
        $user_id = auth()->id(); // Assuming the user is authenticated
        $totalTally = TotalTally::where('user_id', $user_id)->first();

        if ($totalTally === null) {
            // Handle the case where no object is found
            // For example, create a new TotalTally object or set a default value
            $totalTally = new TotalTally();
            $totalTally->user_id = $user_id;
            // Set other properties as required
            $totalTally->save();
        }

        $topUsersByCalls = TotalTally::orderByDesc('calls')->take(5)->get()->map(function ($user) {
            $user->name = User::find($user->user_id)->name;
            return $user;
        });

        $topUsersByDeals = TotalTally::orderByDesc('deals_closed')->take(5)->get()->map(function ($user) {
            $user->name = User::find($user->user_id)->name;
            return $user;
        });

        $topUsersByDemos = TotalTally::orderByDesc('demonstrations')->take(5)->get()->map(function ($user) {
            $user->name = User::find($user->user_id)->name;
            return $user;
        });

        return view('dashboard', ['totalTally' => $totalTally, 
                                'topUsersByCalls' => $topUsersByCalls, 
                                'topUsersByDeals' => $topUsersByDeals,
                                'topUsersByDemos' => $topUsersByDemos,
                            ]);
    }
}
