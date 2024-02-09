<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTally extends Model
{
    use HasFactory;

    protected $table = 'daily_tallies';
    public $timestamps = false;


    protected $fillable = [
        'user_id',
        'date',
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

    public function user_id()
    {
        return $this->belongsTo(User::class);
    }
}

