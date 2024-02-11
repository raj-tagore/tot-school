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
        'phone_calls',
        'appointments',
        'meetings',
        'letters',
        'follow_ups',
        'proposals',
        'policies',
        'premium',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
