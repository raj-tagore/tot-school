<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyTally;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TallyController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::id();
        $date    = Carbon::today()->toDateString();

        $todaysTally = DailyTally::where('date', $date)->where('user_id', $user_id)->first();

        return response()->json([
            'submitted'   => $todaysTally !== null,
            'todaysTally' => $todaysTally,
        ]);
    }

    public function store(Request $request)
    {
        $fields = config('columns.columns', []);

        $validationRules = [];
        foreach ($fields as $key => $value) {
            $validationRules[$key] = 'required|integer|min:0';
        }

        $validatedData          = $request->validate($validationRules);
        $validatedData['user_id'] = Auth::id();
        $validatedData['date']    = Carbon::today()->toDateString();

        $existingEntry = DailyTally::where('date', $validatedData['date'])->where('user_id', $validatedData['user_id'])->first();

        if ($existingEntry) {
            $existingEntry->update($validatedData);
            $message = 'Tally updated successfully';
        } else {
            DailyTally::create($validatedData);
            $message = 'Tally created successfully';
        }

        return response()->json(['message' => $message], 200);
    }
}
