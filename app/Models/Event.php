<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'date',
        'capacity',
        'pricing',
        'enddate',         // Added field
        'game_name',       // Added field
        'double_price',    // Added field
        'user_id'
    ];
}
