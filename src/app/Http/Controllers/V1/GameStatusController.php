<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateGameStatusRequest;
use App\Models\Activity;
use App\Models\GameStatus;
use App\Services\Activity\ActivityService;
use App\Services\Game\GameService;
use Illuminate\Http\JsonResponse;
use \Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

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

    public function update(Request $request, int $gameId): JsonResponse
    {
        $status = GameStatus::where([
            'game_id' => $gameId,
            'user_id' => Auth::user()->uuid,
        ])
        ->first();

        if (!$status instanceof GameStatus) {
            $status = GameStatus::create([
                'game_id' => $gameId,
                'status' => $request->get('status')
            ]);
        }
//
//        if ($status->status === $request->get('status')) {
//            return $this->errorResponse('Status cant be the same', 400);
//        }

        $status->status = $request->get('status');
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
