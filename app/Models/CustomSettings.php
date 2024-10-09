<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomSettings extends Model
{
    protected $table = 'custom_settings';
    public $timestamps = false;
    protected $fillable = ['name', 'value'];
}
