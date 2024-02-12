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
            return redirect()->route('tally'); 
        } else {
            $newEntry = DailyTally::create($validatedData);
            error_log($newEntry);
            if (TotalTally::where('user_id', $validatedData['user_id'])->exists()) {
                $existingValues = TotalTally::where('user_id', $validatedData['user_id'])->first()->toArray();
                $columns = config('columns.columns');
                foreach ($columns as $column => $data) {
                    $existingValues[$column] = $existingValues[$column] + $validatedData[$column];
                }
                TotalTally::where('user_id', $validatedData['user_id'])->update($existingValues);
            }
            else {
                $newTotal = TotalTally::create($validatedData);
                $newTotal->setCreatedAt(Carbon::now());
                $newTotal->save();
            }
            return redirect()->route('tally');
        }
    }
}
