<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\DailyTally; // Assuming you have this model
use App\Models\TotalTally;
use Carbon\Carbon; // For handling date operations
use Illuminate\Support\Facades\Log;


class TallyController extends Controller
{   
    public function index(Request $request) {
        $user_id = auth()->id(); // Assuming the user is authenticated
        $date = Carbon::today()->toDateString(); 
        if (DailyTally::where('date', $date)->where('user_id', $user_id)->exists()) {
            return view('tally', ['submitted' => true]);
        } else {
            return view('tally', ['submitted' => false]);
        }
    }
    /**
     * Handle the submission of the DailyTally form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */ 
    public function store(Request $request)
    {   
        // Validate the request
        $validatedData = $request->validate([
            'visits' => 'required|integer|min:0',
            'calls' => 'required|integer|min:0',
            'leads' => 'required|integer|min:0',
            'registered_leads' => 'required|integer|min:0',
            'phone_calls' => 'required|integer|min:0',
            'calls_confirmed' => 'required|integer|min:0',
            'presentations' => 'required|integer|min:0',
            'demonstrations' => 'required|integer|min:0',
            'letters' => 'required|integer|min:0',
            'second_visits' => 'required|integer|min:0',
            'proposals' => 'required|integer|min:0',
            'deals_closed' => 'required|integer|min:0',
        ]);

        // Add additional data
        $validatedData['user_id'] = auth()->id(); // Assuming the user is authenticated
        $validatedData['date'] = Carbon::today()->toDateString(); 

        // Check if an entry exists for the given date
        if (DailyTally::where('date', $validatedData['date'])->where('user_id', $validatedData['user_id'])->exists()) {
            return response()->json(['message' => 'Entry for this date already exists.']);
        } else {
            $newEntry = DailyTally::create($validatedData);
            if (TotalTally::where('user_id', $validatedData['user_id'])->exists()) {
                $existingValues = TotalTally::where('user_id', $validatedData['user_id'])->first()->toArray();
                $columns = config('columns.columns');
                foreach ($columns as $column => $data) {
                    $existingValues[$column] = $existingValues[$column] + $validatedData[$column];
                }
                TotalTally::where('user_id', $validatedData['user_id'])->update($existingValues);
            }
            else {
                Arr::forget($validatedData, 'created_at');
                Arr::forget($validatedData, 'updated_at');
                TotalTally::create($validatedData);
            }
            return response()->json(['message' => 'New entry created successfully.', 'entry' => $newEntry]);
        }
    }
}
