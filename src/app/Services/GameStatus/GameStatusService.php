<?php

namespace App\Services\GameStatus;

use App\Models\GameStatus;
use Auth;

class GameStatusService
{
    public function getStatusByGameId(int $id)
    {
        $status = GameStatus::where([
            'user_id' => Auth::id(),
            'game_id' => $id
        ])
        ->first();

        if (!$status instanceof GameStatus)
        {
            return GameStatus::STATUS_EMPTY;
        }

        return $status->status;
    }


}