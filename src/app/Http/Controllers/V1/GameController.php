<?php

namespace App\Http\Controllers\V1;

use App\Http\Requests\SearchGameRequest;
use App\Services\Game\GameService;
use App\Services\GameStatus\GameStatusService;
use Illuminate\Support\Collection;
use MarcReichel\IGDBLaravel\Models\Game;
use Symfony\Component\HttpFoundation\Request;
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

    public function show(string $id)
    {
        $game = $this->gameService->fetchById($id);

        return $this->successResponse($game);
    }
}
