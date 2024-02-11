<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyTally extends Model
{
    protected $table = 'daily_tallies'; // Ensure the model uses the correct table
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'date',
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

    // public function __construct(array $attributes = [])
    // {
    //     parent::__construct($attributes);

    //     // Dynamically setting the fillable attributes based on config columns
    //     $this->fillable = array_keys(config('columns.columns', []));
    // }

    // // Static method to get the display names of the columns
    // public static function getColumnDisplayNames()
    // {
    //     return config('columns.columns', []);
    // }

    public function user_id()
    {
        return $this->belongsTo(User::class);
    }
}
