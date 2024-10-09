<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyTally extends Model
{
    protected $table = 'daily_tallies'; // Ensure the model uses the correct table
    public $timestamps = false;
    protected $fillable = [];
    public function __construct($attributes = []) { 
        parent::__construct($attributes);
        $fields2 = collect(config('columns.columns'))->keys()->all();
        $fields1 = [
            'user_id',
            'date',
        ];
        $this->fillable = array_merge($fields1, $fields2);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
 