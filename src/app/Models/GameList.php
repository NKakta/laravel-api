<?php

namespace App\Models;

use App\Contracts\UuidInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameList extends Model implements UuidInterface
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    protected $with = ['listItems'];

    public function listItems()
    {
        return $this->belongsToMany(
            ListItem::class,
            'game_list_list_item',
            'game_list_id',
            'list_item_id');
    }

}
