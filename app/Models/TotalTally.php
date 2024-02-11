<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalTally extends Model
{
    protected $table = 'total_tallies'; // Ensure the model uses the correct table
    public $timestamps = false;
    protected $fillable = [];

    public function __construct($attributes = []) {
        parent::__construct($attributes);
        $fields2 = collect(config('columns.columns'))->keys()->all();
        $fields1 = [
            'user_id',
        ]; 
        $this->fillable = array_merge($fields1, $fields2);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
