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
            ->with(Game::RELATION_FIELDS)
            ->find($id);

        $this->resizeImages($game);
        $game->game_status = $this->gameStatusService->getStatusByGameId((int)$game->id);

        return $game;
    }

    /**
     * @return Collection|Game[]
     */
    public function fetchByName(string $name): Collection
    {
        $list = Game::select(Game::PARSED_FIELDS)
            ->with(Game::RELATION_FIELDS)
            ->search($name)
            ->get();

        foreach ($list as $game) {
            $game->game_status = $this->gameStatusService->getStatusByGameId((int)$game->id);

        }

        return $list;
    }

    private function resizeImages($game)
    {
        if (!$game) {
            return;
        }

        if ($game->cover) {
            $game->cover->url = str_replace('t_thumb', Game::IMAGE_SIZE_BIG, $game->cover->url);
        }

        if ($game->screenshots) {
            foreach ($game->screenshots as $screenshot) {
                $screenshot->url = str_replace('t_thumb', Game::IMAGE_SIZE_BIG, $screenshot->url);
            }
        }
    }
}
