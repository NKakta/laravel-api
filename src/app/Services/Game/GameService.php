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
        $this->addUrlToVideos($game);
        $game->game_status = $this->gameStatusService->getStatusByGameId((int)$game->id);

        return $game;
    }

    public function fetchPopular()
    {
        $list = Game::select(Game::PARSED_FIELDS)
            ->with(Game::RELATION_FIELDS)
            ->where('first_release_date', '>', now()->toString())
            ->where('first_release_date', '<', (new \DateTime('+4 months'))->format('Y-m-d H:i:s'))
            ->orderBy('rating', 'desc')
            ->limit(12)
            ->get();

        foreach ($list as $game) {
            $this->resizeImages($game);
            $this->addUrlToVideos($game);
            $game->game_status = $this->gameStatusService->getStatusByGameId((int)$game->id);
        }


        return $list;
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

    private function addUrlToVideos($game) {
        if (!$game) {
            return;
        }

        if ($game->videos) {
            foreach ($game->videos as $video) {
                $video->url = 'https://www.youtube.com/watch?v=' . $video->video_id;
            }
        }
    }
}
