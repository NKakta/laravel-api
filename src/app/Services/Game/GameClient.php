<?php
declare(strict_types=1);

namespace App\Services\Game;

use App\Models\Game;

class GameClient
{
    public function fetchById(int $id)
    {
        return Game::select(Game::PARSED_FIELDS)
            ->with(Game::RELATION_FIELDS)
            ->find($id);
    }

    public function fetchPopular()
    {
        return Game::select(Game::PARSED_FIELDS)
            ->with(Game::RELATION_FIELDS)
            ->where('first_release_date', '>', now()->toString())
            ->where('first_release_date', '<', (new \DateTime('+4 months'))->format('Y-m-d H:i:s'))
            ->orderBy('rating', 'desc')
            ->limit(12)
            ->get();
    }

    public function fetchByName(string $name)
    {
        return Game::select(Game::PARSED_FIELDS)
            ->with(Game::RELATION_FIELDS)
            ->search($name)
            ->get();
    }

    public function fetchInIds(array $ids)
    {
        return Game::select(Game::PARSED_FIELDS)
            ->with(Game::RELATION_FIELDS)
            ->whereIn('id', $ids)
            ->get();
    }
}
