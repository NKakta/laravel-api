<?php
declare(strict_types=1);

namespace App\Models;

use App\Contracts\UuidInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model implements UuidInterface
{
    use HasFactory;

    const ACTION_LIST_CREATED = 'list_created';
    const ACTION_REVIEW_CREATED = 'review_created';
    const ACTION_STATUS_UPDATED = 'game_status_updated';

    protected $fillable = ['game_id', 'game_name', 'action', 'data', 'cover_url'];

    protected $casts = ['data' => 'array'];

    protected $attributes = ['data' => '{}'];
}
