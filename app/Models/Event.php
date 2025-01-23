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
        'game_start_date',
        'game_end_date',
        'date',
        'capacity',
        'pricing',
        'enddate',
        'game_name',
        'double_price',
        'user_id',
        'selected_game',
        'skill_level',
    ];

    public function userevent()
    {
        return $this->belongsTo(UserEvent::class, 'id', 'event_id');
    }
}
