<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalTally extends Model
{
    use HasFactory;
    protected $table = 'total_tallies';
    public $timestamps = false;

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
