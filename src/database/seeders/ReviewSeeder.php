<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\GameList;
use App\Models\ListItem;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public const REVIEW_ID_1 = 1;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->createReview(
            self::REVIEW_ID_1,
            'review-1',
            'content-1',
            1,
            UserSeeder::DEFAULT_USER_ID
        );
    }

    private function createReview($id, $title, $content, $positive, $userId = null)
    {
        return Review::create([
            'id'            => $id,
            'uuid'          => $id,
            'user_id'       => $userId,
            'game_id'       => 1,
            'title'         => $title,
            'content'       => $content,
            'positive'      => $positive,
        ]);
    }
}
