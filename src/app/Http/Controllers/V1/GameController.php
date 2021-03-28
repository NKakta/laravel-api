<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Requests\SearchGameRequest;
use App\Services\Game\GameService;
use App\Http\Controllers\ApiController;
use App\Services\Review\ReviewService;

class GameController extends ApiController
{
    /**
     * @var GameService
     */
    private $gameService;

    /**
     * @var ReviewService
     */
    private $reviewService;

    public function __construct(GameService $gameService, ReviewService $reviewService)
    {
        $this->gameService = $gameService;
        $this->reviewService = $reviewService;
    }

    public function search(SearchGameRequest $request)
    {
        $game = $this->gameService->fetchByName($request->name);

        return $this->successResponse($game);
    }

    public function show(int $id)
    {
        $game = $this->gameService->fetchById($id);

        return $this->successResponse($game);
    }

    public function showPopular()
    {
        $list = $this->gameService->fetchPopular();

        return $this->successResponse($list);
    }

    public function getReviewInfo(int $id)
    {
        $info = $this->reviewService->getReviewsForGame($id);

        return $this->successResponse($info, null, 200);
    }
}
