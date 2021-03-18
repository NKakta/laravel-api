<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Requests\SearchGameRequest;
use App\Services\Game\GameService;
use App\Http\Controllers\ApiController;

class GameController extends ApiController
{
    /**
     * @var GameService
     */
    private $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
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
}
