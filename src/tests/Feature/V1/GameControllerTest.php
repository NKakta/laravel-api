<?php
declare(strict_types=1);

namespace Tests\Feature\V1;

use App\Models\Game;
use App\Models\Review;
use App\Models\User;
use App\Services\Game\GameClient;
use App\Services\GameStatus\GameStatusService;
use Database\Seeders\ReviewSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Laravel\Passport\Passport;
use MarcReichel\IGDBLaravel\Models\GameVideo;
use Tests\TestCase;

class GameControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    /**
     * @test
     */
    public function authorized_user_able_to_search_for_games(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        $gameClient = $this->mock(GameClient::class);
        $statusService = $this->mock(GameStatusService::class);

        $game = $this->mockGame(0);

        $statusService
            ->shouldReceive('getStatusByGameId')
            ->once()
            ->with(116797)
            ->andReturn('active');

        $gameClient
            ->shouldReceive('fetchByName')
            ->once()
            ->with('game')
            ->andReturn(new Collection([$game]));

        $response = $this->json('GET', route('games.search'), ['name' => 'game']);

        $this->assertJsonResponse($response, [
            [
                'category' => 0,
                'cover' => null,
                'first_release_date' => '1970-01-01T00:34:10.000000Z',
                'game_status' => 'active',
                'genres' => [['id' => 14, 'name' => 'Sport',]],
                'id' => 116797,
                'involved_companies' => [78960],
                'name' => 'Olympic Games Tokyo 2020: The Official Video Game',
                'platforms' => [['abbreviation' => 'PC', 'id' => 6, 'name' => 'PC (Microsoft Windows)']],
                'screenshots' => null,
                'summary' => 'A fun-filled sports action game where you can create your own avatar and compete in Olympic Games events with people around the world.',
                'title' => 'game1',
                'videos' => [['id' => 26762, 'name' => 'Trailer', 'video_id' => 'FDRV86UdgnM',]]
            ]
        ]);
    }

    /** @test */
    public function authorized_user_able_to_find_nothing(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        $response = $this->json('GET', route('user.search'), ['name' => 'does-not-exist']);

        $this->assertJsonResponse($response, []);
    }

    /** @test */
    public function authorized_user_able_to_fetch_popular_games(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        $gameClient = $this->mock(GameClient::class);
        $statusService = $this->mock(GameStatusService::class);

        $game = $this->mockGame(0);

        $video = new GameVideo($game->videos[0]);
        $game->videos = new Collection([$video]);

        $statusService
            ->shouldReceive('getStatusByGameId')
            ->once()
            ->andReturn('active');

        $gameClient
            ->shouldReceive('fetchPopular')
            ->once()
            ->andReturn(new Collection([$game]));

        $response = $this->json('GET', route('games.popular'));

        $this->assertJsonResponse($response, [
            [
                'category' => 0,
                'cover' => null,
                'first_release_date' => '1970-01-01T00:34:10.000000Z',
                'game_status' => 'active',
                'genres' => [['id' => 14, 'name' => 'Sport',]],
                'id' => 116797,
                'involved_companies' => [78960],
                'name' => 'Olympic Games Tokyo 2020: The Official Video Game',
                'platforms' => [['abbreviation' => 'PC', 'id' => 6, 'name' => 'PC (Microsoft Windows)']],
                'screenshots' => null,
                'summary' => 'A fun-filled sports action game where you can create your own avatar and compete in Olympic Games events with people around the world.',
                'title' => 'game1',
                'videos' => [['id' => 26762, 'name' => 'Trailer', 'video_id' => 'FDRV86UdgnM','url' => 'https://www.youtube.com/watch?v=FDRV86UdgnM']]
            ]
        ]);
    }

    /** @test */
    public function authorized_user_able_to_fetch_review_info(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        $review = Review::find(ReviewSeeder::REVIEW_ID_1);

        $response = $this->json('GET', route('games.review.info', 1));

        $this->assertJsonResponse($response, [
            'positiveCount' => 1,
            'negativeCount' => 0,
            'reviews' => [
                [
                    'uuid' => $review->uuid,
                    'user_id' => $review->user_id,
                    'game_id' => $review->game_id,
                    'title' => $review->title,
                    'content' => $review->content,
                    'positive' => $review->positive,
                    'created_at' => $review->created_at,
                    'updated_at' => $review->updated_at,
                    'user' => $review->user,
                ]
            ],
        ]);
    }

    private function mockGame($id)
    {
        $data = json_decode(File::get(base_path('/tests/Stubs/Game/search-games.json')), true);

        return new Game([
                'title' => 'game1',
                'cover' => null,
                'game_status' => null,
                'screenshots' => null
            ] + $data[$id]
        );
    }
}
