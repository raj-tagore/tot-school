<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalTally extends Model
{
    protected $table = 'total_tallies'; // Ensure the model uses the correct table
    public $timestamps = false;
    // Dynamically set fillable fields based on config
    protected $fillable = [
        'user_id',
        'visits',
        'calls',
        'leads',
        'registered_leads',
        'phone_calls',
        'calls_confirmed',
        'presentations',
        'demonstrations',
        'letters',
        'second_visits',
        'proposals',
        'deals_closed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
