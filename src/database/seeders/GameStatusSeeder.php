<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\GameStatus;
use Illuminate\Database\Seeder;

class GameStatusSeeder extends Seeder
{
    public const STATUS_ID_1 = 1;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->createStatus(
            self::STATUS_ID_1,
            1,
            'playing',
            UserSeeder::DEFAULT_USER_ID
        );
    }

    private function createStatus($id, $gameId, $status, $userId)
    {
        return GameStatus::create([
            'id' => $id,
            'game_id' => $gameId,
            'status' => $status,
            'user_id' => $userId,
        ]);

    }
}
