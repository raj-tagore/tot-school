<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\DailyTally; 
use App\Models\TotalTally;
use Carbon\Carbon; // For handling date operations
use Illuminate\Support\Facades\Log;


class TallyController extends Controller
{   
    public function index(Request $request) {
        $user_id = auth()->id(); 
        $date = Carbon::today()->toDateString(); 
        if (DailyTally::where('date', $date)->where('user_id', $user_id)->exists()) {
            $todaysTally = DailyTally::where('date', $date)->where('user_id', $user_id)->first();
            return view('tally', ['submitted' => true, 'todaysTally' => $todaysTally]);
        } else {
            return view('tally', ['submitted' => false]);
        }
    }
    
    public function store(Request $request)
    {   
        $fields = config('columns.columns', []);

        $validationRules = [];
        foreach ($fields as $key => $value) {
            $validationRules[$key] = 'required|integer|min:0';
        }
        
        // Validate the request
        $validatedData = $request->validate($validationRules);

        // Add additional data
        $validatedData['user_id'] = auth()->id(); // Assuming the user is authenticated
        $validatedData['date'] = Carbon::today()->toDateString(); 

        // Check if an entry exists for the given date
        if (DailyTally::where('date', $validatedData['date'])->where('user_id', $validatedData['user_id'])->exists()) {
            $existingEntry = DailyTally::where('date', $validatedData['date'])->where('user_id', $validatedData['user_id'])->first();
            $existingEntry->update($validatedData);
            return redirect()->route('tally'); 
        } else {
            $newEntry = DailyTally::create($validatedData);
            return redirect()->route('tally');
        }
    }
}
