<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameStatus extends Model
{
    const STATUS_PLAYED = 'played';
    const STATUS_WANT = 'want';
    const STATUS_PLAYING = 'playing';
    const STATUS_EMPTY = 'empty';

    const STATUSES = [
        self::STATUS_PLAYED,
        self::STATUS_WANT,
        self::STATUS_PLAYING,
        self::STATUS_EMPTY,
    ];

    protected $fillable = ['status', 'game_id', 'user_id'];

    use HasFactory;
}
