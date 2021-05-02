<?php
declare(strict_types=1);

namespace Tests\Feature\V1;

use App\Models\GameList;
use App\Models\User;
use Database\Seeders\ListSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ListItemControllerTest extends TestCase
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
    public function authorized_user_able_to_get_lists(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        $gameList = GameList::find(ListSeeder::LIST_ID_1);

        $gameList2 = GameList::find(ListSeeder::LIST_ID_2);

        $response = $this->json('GET', route('lists.index'));

        $this->assertJsonResponse($response, [
                [
                    'uuid' => $gameList->uuid,
                    'user_id' => $gameList->user_id,
                    'name' => $gameList->name,
                    'description' => $gameList->description,
                    'count' => $gameList->count,
                    'cover_urls' => $gameList->cover_urls,
                    'created_at' => $gameList->created_at,
                    'updated_at' => $gameList->updated_at,
                    'list_items' => []
                ],
                [
                    'uuid' => $gameList2->uuid,
                    'user_id' => $gameList2->user_id,
                    'name' => $gameList2->name,
                    'description' => $gameList2->description,
                    'count' => $gameList2->count,
                    'cover_urls' => $gameList2->cover_urls,
                    'created_at' => $gameList2->created_at,
                    'updated_at' => $gameList2->updated_at,
                    'list_items' => []
                ]
            ]
        );
    }

    /** @test */
    public function authorized_user_able_to_find_nothing(): void
    {
        Passport::actingAs(User::find(2), ['*']);

        $response = $this->json('GET', route('lists.index'));

        $this->assertJsonResponse($response, []);
    }

    /** @test */
    public function able_to_create(): void
    {
        Passport::actingAs(User::find(2), ['*']);

        $response = $this->json('POST', route('lists.store'), [
            'name'          => 'new-name',
            'description'   => 'new-description'
        ]);

        $this->assertDatabaseHas('game_lists', [
            'name' => 'new-name',
            'description' => 'new-description'
        ]);

        $this->assertJson($response->getContent(), json_encode([
            'name' => 'new-name',
            'description' => 'new-description',
            'user_id' => 2,
        ]));
    }

    /** @test */
    public function able_to_show(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        /** @var GameList $user */
        $gameList = GameList::find(ListSeeder::LIST_ID_1);

        $response = $this->json('GET', route('lists.show', $gameList->uuid));

        $this->assertJsonResponse($response, [
                'uuid' => $gameList->uuid,
                'user_id' => $gameList->user_id,
                'name' => $gameList->name,
                'description' => $gameList->description,
                'count' => $gameList->count,
                'cover_urls' => $gameList->cover_urls,
                'created_at' => $gameList->created_at,
                'updated_at' => $gameList->updated_at,
                'list_items' => [],
            ]
        );
    }

    /** @test */
    public function able_to_update(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        /** @var GameList $user */
        $gameList = GameList::find(ListSeeder::LIST_ID_1);

        $response = $this->json('PUT', route('lists.update', $gameList->uuid),[
            'name'          => 'new_name',
            'description'   => 'new_description'
        ]);

        $gameList->refresh();

        $this->assertJsonResponse($response, [
                'uuid' => $gameList->uuid,
                'user_id' => $gameList->user_id,
                'name' => $gameList->name,
                'description' => $gameList->description,
                'count' => $gameList->count,
                'cover_urls' => $gameList->cover_urls,
                'created_at' => $gameList->created_at,
                'updated_at' => $gameList->updated_at,
                'list_items' => [],
            ]
        );
    }

    /** @test */
    public function able_to_destroy(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        /** @var GameList $user */
        $gameList = GameList::find(ListSeeder::LIST_ID_1);

        $response = $this->json('DELETE', route('lists.destroy', $gameList->uuid),);

        $response->assertStatus(204);
        $this->assertEquals($response->getContent(), null);
    }
}
