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
        'genres'
    ];

    public const RELATION_FIELDS = [
        'cover' => ['url'],
        'screenshots' => ['url'],
        'genres' => ['name'],
        'platforms' => ['abbreviation', 'name'],
    ];

    public const IMAGE_SIZE_BIG = 't_cover_big_2x';
}
