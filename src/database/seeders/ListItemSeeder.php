<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\FollowerUser;
use App\Models\ListItem;
use Illuminate\Database\Seeder;

class ListItemSeeder extends Seeder
{
    public const LIST_ITEM_ID_1 = 1;
    public const LIST_ITEM_ID_2 = 2;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->createListItem(
            self::LIST_ITEM_ID_1,
            'item-1',
            1,
        );
    }


    private function createListItem($id, $name, $gameId)
    {
        return ListItem::create([
            'id'            => $id,
            'uuid'          => $id,
            'name'          => $name,
            'game_id'       => $gameId,
        ]);
    }
}
