<?php
declare(strict_types=1);

namespace App\Services\Activity;

use App\Models\Activity;
use App\Models\Game;

class ActivityService
{
    public function create(string $action, array $data = null, Game $game = null): Activity
    {
        $coverUrl = null;
        $gameId = null;

        if ($game) {
            $coverUrl = $game->getCoverUrl();
            $gameId = $game->id;
        }

        return Activity::create([
            'action' => $action,
            'cover_url' => $coverUrl,
            'game_id' => $gameId,
            'data' => $data,
        ]);
    }
}
