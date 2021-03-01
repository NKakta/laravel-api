<?php

namespace App\Services\Game;

use App\Models\Game;
use App\Services\GameStatus\GameStatusService;
use Illuminate\Support\Collection;

class GameService
{
    /**
     * @var GameStatusService
     */
    private $gameStatusService;

    public function __construct(GameStatusService $gameStatusService)
    {
        $this->gameStatusService = $gameStatusService;
    }

    public function fetchById(int $id): Game
    {
        $game = Game::select(Game::PARSED_FIELDS)
            ->with(['cover' => ['height', 'url', 'width']])
            ->find($id);

        $game->game_status = $this->gameStatusService->getStatusByGameId((int)$game->id);

        return $game;
    }

    /**
     * @return Collection|Game[]
     */
    public function fetchByName(string $name): Collection
    {
        return Game::select(Game::PARSED_FIELDS)
            ->with(['cover' => ['height', 'url', 'width']])
            ->search($name)
            ->get();
    }
}
