<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateGameStatusRequest;
use App\Models\GameStatus;
use \Illuminate\Support\Facades\Auth;

class GameStatusController extends ApiController
{
    public function update(CreateGameStatusRequest $request, int $gameId)
    {
        $gameStatus = GameStatus::firstOrCreate(
            [
                'game_id' => $gameId,
                'user_id' => Auth::id(),
            ],
            [
                'game_id' => $gameId,
                'user_id' => Auth::id(),
                'status' => $request->status
            ]);

        $gameStatus->status = $request->status;
        $gameStatus->updateTimestamps();


        return $this->successResponse($gameStatus);
    }
}
