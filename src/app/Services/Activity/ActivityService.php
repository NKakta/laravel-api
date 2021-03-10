<?php
declare(strict_types=1);

namespace App\Services\Activity;

use App\Models\Activity;

class ActivityService
{
    public function create(string $action, array $data = null, int $gameId = null): Activity
    {
        return Activity::create([
            'action' => $action,
            'game_id' => $gameId,
            'data' => $data,
        ]);
    }
}
