<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateGameStatusRequest;
use App\Models\Activity;
use App\Models\GameStatus;
use App\Services\Activity\ActivityService;
use App\Services\Game\GameService;
use \Illuminate\Support\Facades\Auth;

class GameStatusController extends ApiController
{
    /**
     * @var ActivityService
     */
    private $activityService;

    /**
     * @var GameService
     */
    private $gameService;

    public function __construct(ActivityService $activityService, GameService $gameService)
    {
        $this->activityService = $activityService;
        $this->gameService = $gameService;
    }

    public function update(CreateGameStatusRequest $request, int $gameId)
    {
        $status = GameStatus::where([
                'game_id' => $gameId,
                'user_id' => Auth::id(),
        ])
        ->first();

        if ($status instanceof GameStatus) {
            if ($status->status === $request->status) {
                throw new \Exception('Status can\'t be the same', 400);
            }
        } else {
            $status = GameStatus::create([
                'game_id' => $gameId,
                'status' => $request->status
            ]);
        }

        $status->updateTimestamps();
        $status->save();

        $this->activityService->create(
            Activity::ACTION_STATUS_UPDATED,
            [
                'game_name' => $this->gameService->fetchById($gameId)->name,
                'status' => $status->status
            ],
            $gameId
        );

        return $this->successResponse($status);
    }
}
