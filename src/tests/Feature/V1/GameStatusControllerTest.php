<?php
declare(strict_types=1);

namespace Tests\Feature\V1;

use App\Models\GameList;
use App\Models\GameStatus;
use App\Models\User;
use Database\Seeders\GameStatusSeeder;
use Database\Seeders\ListSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GameStatusControllerTest extends TestCase
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
    public function able_to_update_existing_status(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        $response = $this->json('POST', route('status.update', ['gameId' => 1]), ['status' => 'playing']);

        $status = GameStatus::find(GameStatusSeeder::STATUS_ID_1);

        $this->assertJsonResponse($response, [
                    'game_id' => $status->game_id,
                    'status' => $status->status,
                    'uuid' => $status->uuid,
                    'user_id' => $status->user_id,
                    'updated_at' => $status->updated_at,
                    'created_at' => $status->created_at,
            ]
        );
    }

    /** @test */
    public function creates_status_if_empty(): void
    {
        Passport::actingAs(User::find(UserSeeder::DEFAULT_USER_ID), ['*']);

        $response = $this->json('POST', route('status.update', ['gameId' => 100]), ['status' => 'playing']);

        $responseData = $response->json('data');

        $response->assertStatus(200);
        static::assertEquals($responseData['game_id'], 100);
        static::assertEquals($responseData['user_id'], UserSeeder::DEFAULT_USER_ID);
    }
}
