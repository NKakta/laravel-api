<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\GameList;
use App\Models\ListItem;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public const ACTIVITY_ID_1 = 1;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->createActivity(
            self::ACTIVITY_ID_1,
            'activity-action',
            'http://example.com',
            1,
            UserSeeder::DEFAULT_USER_ID
        );
    }

    private function createActivity($id, $action, $coverUrl, $gameId, $userId)
    {
        return Activity::create([
            'id' => $id,
            'action' => $action,
            'cover_url' => $coverUrl,
            'game_id' => $gameId,
            'data' => [],
            'user_id' => $userId
        ]);
    }
}
