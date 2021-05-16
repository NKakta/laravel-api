<?php

namespace App\Models;

use MarcReichel\IGDBLaravel\Models\Game as IgdbGame;

class Game extends IgdbGame
{
    public const PARSED_FIELDS = [
        'id',
        'name',
        'first_release_date',
        'cover',
        'aggregated_rating',
        'game_engines',
        'genres',
        'category',
        'platforms',
        'summary',
        'storyline',
        'involved_companies',
        'collection',
        'genres',
        'videos',
    ];

    public const RELATION_FIELDS = [
        'cover' => ['url'],
        'screenshots' => ['url'],
        'genres' => ['name'],
        'platforms' => ['abbreviation', 'name'],
        'videos' => ['name', 'video_id'],
    ];

    public const IMAGE_SIZE_BIG = 't_cover_big_2x';

    public function getCoverUrl()
    {
        if (!isset($this->cover) || !(isset($this->cover->url))) {
            return null;
        }

        if ($this->cover->url) {
            return $this->cover->url = str_replace('t_thumb', Game::IMAGE_SIZE_BIG, $this->cover->url);
        }
        return null;
    }
}
