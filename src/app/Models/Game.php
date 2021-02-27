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
        'category',
        'platforms',
        'summary',
        'involved_companies',
        'collection',
        'genres'
    ];
}
