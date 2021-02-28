<?php

namespace App\Models;

use App\Contracts\UuidInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model implements UuidInterface
{
    use HasFactory;

    const ACTION_LIST_CREATED = 'list_created';
    const ACTION_STATUS_UPDATED = 'game_status_updated';

    protected $fillable = ['game_id', 'game_name', 'action', 'data'];

    protected $casts = ['data' => 'array'];

    protected $attributes = ['data' => '{}'];
}
