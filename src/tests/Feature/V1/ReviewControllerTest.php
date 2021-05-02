<?php
declare(strict_types=1);

namespace Tests\Feature\V1;

use App\Models\GameList;
use App\Models\Review;
use App\Models\User;
use Database\Seeders\ReviewSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ReviewControllerTest extends TestCase
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
    public function authorized_user_able_to_index(): void
    {
        Passport::actingAs(User::find(UserSeeder::DEFAULT_USER_ID), ['*']);

        /** @var GameList $user */
        $review = Review::find(ReviewSeeder::REVIEW_ID_1);

        $response = $this->json('GET', route('reviews.index'));

        $this->assertJsonResponse($response, [
                [
                    'uuid' => $review->uuid,
                    'user_id' => $review->user_id,
                    'created_at' => $review->created_at,
                    'updated_at' => $review->updated_at,
                    'game_id' => $review->game_id,
                    'title' => $review->title,
                    'content' => $review->content,
                    'positive' => $review->positive,
                    'user' => $review->user,
                ]
            ]
        );
    }

    /** @test */
    public function authorized_user_able_to_find_nothing(): void
    {
        Passport::actingAs(User::find(2), ['*']);

        $response = $this->json('GET', route('reviews.index'));

        $this->assertJsonResponse($response, []);
    }

    /** @test */
    public function able_to_create(): void
    {
        Passport::actingAs(User::find(2), ['*']);

        $response = $this->json('POST', route('reviews.store'), [
            'game_id'   => 1,
            'title'     => 'new-title',
            'content'   => 'new-content',
            'positive'  =>  1
        ]);

        $this->assertDatabaseHas('reviews', [
            'game_id'   => 1,
            'title'     => 'new-title',
            'content'   => 'new-content',
            'positive'  =>  1
        ]);

        $response->assertStatus(200);

        $this->assertEquals($response['data']['game_id'], 1);
        $this->assertEquals($response['data']['title'], 'new-title');
        $this->assertEquals($response['data']['content'], 'new-content');
        $this->assertEquals($response['data']['positive'], 1);

    }

    /** @test */
    public function able_to_show(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        /** @var GameList $user */
        $review = Review::find(ReviewSeeder::REVIEW_ID_1);

        $response = $this->json('GET', route('reviews.show', $review->uuid));

        $this->assertJsonResponse($response, [
                'uuid' => $review->uuid,
                'user_id' => $review->user_id,
                'created_at' => $review->created_at,
                'updated_at' => $review->updated_at,
                'game_id' => $review->game_id,
                'title' => $review->title,
                'content' => $review->content,
                'positive' => $review->positive,
                'user' => $review->user,
            ]
        );
    }

    /** @test */
    public function able_to_update(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        /** @var GameList $user */
        $review = Review::find(ReviewSeeder::REVIEW_ID_1);

        $response = $this->json('PUT', route('reviews.update', $review->uuid),[
            'game_id'   =>  1,
            'title'     => 'new-title',
            'content'   => 'new-content',
            'positive'  =>  1
        ]);

        $review->refresh();

        $this->assertJsonResponse($response, [
                'uuid' => $review->uuid,
                'user_id' => $review->user_id,
                'created_at' => $review->created_at,
                'updated_at' => $review->updated_at,
                'game_id' => $review->game_id,
                'title' => $review->title,
                'content' => $review->content,
                'positive' => $review->positive,
                'user' => $review->user,
            ]
        );
    }

    /** @test */
    public function able_to_destroy(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        /** @var GameList $user */
        $review = Review::find(ReviewSeeder::REVIEW_ID_1);

        $response = $this->json('DELETE', route('reviews.destroy', $review->uuid),);

        $response->assertStatus(204);
        $this->assertEquals($response->getContent(), null);
    }
}
