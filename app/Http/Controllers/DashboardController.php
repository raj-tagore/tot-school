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
        $todaysTally = DailyTally::where('user_id', $user_id)->where('date', Carbon::today())->first();

        $count = DailyTally::where('user_id', $user_id)->count();

        if ($todaysTally === null) {
            $todaysTally = collect(config('columns.columns'))->mapWithKeys(function ($item, $key) {
                // Use the 'name' as the key and initialize 'value' to 0
                return [$key => 0];
            });
        }

        if ($totalTally === null) {
            // Handle the case where no object is found
            // For example, create a new TotalTally object or set a default value
            $totalTally = new TotalTally();
            $totalTally->user_id = $user_id;
            $totalTally->setCreatedAt(Carbon::now());
            // Set other properties as required
            $totalTally->save();
        }

        $allUsers = TotalTally::all()->map(function ($user) {
            $user->name = User::find($user->user_id)->name;
            return $user;
        });

        return view('dashboard', ['totalTally' => $totalTally,
                                'todaysTally' => $todaysTally, 
                                'allUsers' => $allUsers,
                                'count' => $count,
                            ]);
    }
}
