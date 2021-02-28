<?php

namespace App\Models;

use App\Contracts\UuidInterface;
use App\Services\Game\GameService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListItem extends Model implements UuidInterface
{
    use HasFactory;

    protected $fillable = ['game_id', 'name'];

    public function gameLists()
    {
        return $this->belongsToMany(
            GameList::class,
            'game_list_list_item',
            'list_item_id',
        'game_list_id');
    }
}
