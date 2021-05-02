<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\GameList;
use App\Models\ListItem;
use Illuminate\Database\Seeder;

class ListSeeder extends Seeder
{
    public const LIST_ID_1 = 1;
    public const LIST_ID_2 = 2;

    public const LIST_ITEM_ID_1 = 1;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->createList(
            self::LIST_ID_1,
            'list-1',
            'description-1',
            UserSeeder::DEFAULT_USER_ID
        );

        $this->createList(
            self::LIST_ID_2,
            'list-2',
            'description-2',
            UserSeeder::DEFAULT_USER_ID
        );
    }

    private function createList($id, $name, $description, $userId = null)
    {
        return GameList::create([
            'id'            => $id,
            'uuid'          => $id,
            'name'          => $name,
            'description'   => $description,
            'user_id'       => $userId
        ]);
    }
}
