<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'event_id', 'sender_opponent_id', 'reciver_opponent_id', 'latitude', 'longitude', 'score', 'status', 'selected_game', 'partners_scores'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}