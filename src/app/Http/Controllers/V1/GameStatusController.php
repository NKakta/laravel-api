<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateGameStatusRequest;
use App\Models\Activity;
use App\Models\GameStatus;
use App\Services\Activity\ActivityService;
use App\Services\Game\GameService;
use App\Services\GameStatus\GameStatusService;
use Illuminate\Http\JsonResponse;
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

    /**
     * @var GameStatusService
     */
    private $statusService;

    public function __construct(
        ActivityService $activityService,
        GameService $gameService,
        GameStatusService $statusService
    ) {
        $this->activityService = $activityService;
        $this->gameService = $gameService;
        $this->statusService = $statusService;
    }

    public function update(CreateGameStatusRequest $request, int $gameId): JsonResponse
    {
        $status = GameStatus::where([
            'game_id' => $gameId,
            'user_id' => Auth::user()->id,
        ])
        ->first();

        if (!$status instanceof GameStatus) {
            $status = GameStatus::create([
                'game_id' => $gameId,
                'status' => $request->status
            ]);
        }

        $status->status = $request->status;
        $status->updateTimestamps();
        $status->save();

        $game = $this->gameService->fetchById($gameId);

        $this->activityService->create(
            Activity::ACTION_STATUS_UPDATED,
            [
                'game_name' => $game->name,
                'status' => $status->status
            ],
            $game
        );

        return $this->successResponse($status);
    }
}
