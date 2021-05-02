<?php
declare(strict_types=1);

namespace Tests\Feature\V1;

use App\Models\Activity;
use App\Models\User;
use Database\Seeders\ActivitySeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class FollowerControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    /** @test */
    public function able_to_index(): void
    {
        Passport::actingAs(User::find(2), ['*']);

        /** @var User $user */
        $user = User::find(UserSeeder::DEFAULT_USER_ID);

        $response = $this->json('GET', route('followers.index'));

        $this->assertJsonResponse($response, [
            [
                'name' => $user->name,
                'uuid' => $user->uuid,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'is_followed' => $user->is_followed,
                'pivot' => [
                    'user_id' => '2',
                    'follower_id' => '1'
                ],
            ]
        ]);
    }

    /** @test */
    public function able_to_show_news_feed(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        $activity = Activity::find(ActivitySeeder::ACTIVITY_ID_1);

        $response = $this->json('GET', route('user.news-feed'));

        $this->assertJsonResponse($response, [
                [
                    'uuid' => $activity->uuid,
                    'game_id' => $activity->game_id,
                    'action' => $activity->action,
                    'data' => [],
                    'cover_url' => $activity->cover_url,
                    'created_at' => $activity->created_at,
                    'updated_at' => $activity->updated_at,
                ]
            ]
        );
    }

    /** @test */
    public function able_to_unfollow(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        /** @var User $user */
        $user = User::find(UserSeeder::DEFAULT_USER_ID);

        $response = $this->json('DELETE', route('followers.unfollow', $user->uuid),);

        $response->assertStatus(200);

        $this->assertJsonResponse($response, []);
    }
}
