<?php

namespace App\Services\Game;

use App\Models\Game;
use App\Services\GameStatus\GameStatusService;
use App\Services\Review\ReviewService;
use Illuminate\Support\Collection;

class GameService
{
    /**
     * @var GameStatusService
     */
    private $gameStatusService;

    /**
     * @var ReviewService
     */
    private $reviewService;
    /**
     * @var GameClient
     */
    private $gameClient;

    public function __construct(GameStatusService $gameStatusService, ReviewService $reviewService, GameClient $gameClient)
    {
        $this->gameStatusService = $gameStatusService;
        $this->reviewService = $reviewService;
        $this->gameClient = $gameClient;
    }

    public function fetchById(int $id): Game
    {
        $game = $this->gameClient->fetchById($id);

        $this->resizeImages($game);
        $this->addUrlToVideos($game);
        $game->game_status = $this->gameStatusService->getStatusByGameId((int)$game->id);
        $game->review = $this->reviewService->getReviewForGame((int)$game->id);

        return $game;
    }

    public function fetchPopular()
    {
        $list = $this->gameClient->fetchPopular();

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
        $list = $this->gameClient->fetchByName($name);

        foreach ($list as $game) {
            $this->resizeImages($game);
            $game->game_status = $this->gameStatusService->getStatusByGameId((int)$game->id);
        }

        return $list;
    }

    /**
     * @return Collection|Game[]
     */
    public function fetchByStatus(string $status): Collection
    {
        $statuses = $this->gameStatusService->getStatusesForUser($status);
        $gameIds = [];
        $statusMap = [];

        foreach ($statuses as $status)
        {
            $statusMap[$status->game_id] = $status->status;
            $gameIds[] = $status->game_id;
        }

        $games = $this->gameClient->fetchInIds($gameIds);

        foreach ($games as $game) {
            $this->resizeImages($game);
            $this->addUrlToVideos($game);

            if (isset($statusMap[$game->id])) {
                $game->game_status = $statusMap[$game->id];
            }
        }

        return $games;
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
