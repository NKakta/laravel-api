<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\FollowerUser;
use Illuminate\Database\Seeder;

class FollowerSeeder extends Seeder
{
    public const FOLLOW_ID_1 = 1;
    public const FOLLOW_ID_2 = 2;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->createFollow(
            self::FOLLOW_ID_1,
            UserSeeder::DEFAULT_USER_ID,
            UserSeeder::USER_ID_2,
        );

        $this->createFollow(
            self::FOLLOW_ID_2,
            UserSeeder::USER_ID_2,
            UserSeeder::DEFAULT_USER_ID,
        );
    }

    private function createFollow($id, $userId, $followerId)
    {
        return FollowerUser::create([
            'id'            => $id,
            'user_id'          => $userId,
            'follower_id'       => $followerId,
        ]);
    }
}
