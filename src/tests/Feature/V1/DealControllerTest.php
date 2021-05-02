<?php
declare(strict_types=1);

namespace Tests\Feature\V1;

use App\Models\GameList;
use App\Models\User;
use App\Services\Deal\DealService;
use App\Services\GameStatus\GameStatusService;
use Database\Seeders\ListSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class DealControllerTest extends TestCase
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
    public function authorized_user_able_to_get_deals(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        $dealService = $this->mock(DealService::class);

        $dealResponse = [
            [
                'list' => [
                    [
                        'price_new' => 14.99,
                        'price_old' => 14.99,
                        'price_cut' => 0,
                        'url' => 'https://store.steampowered.com/sub/2535/',
                        'shop' => ['id' => 'steam', 'name' => 'Steam',],
                        'drm' => ['steam',],
                    ],
                ],
                'urls' => ['game' => 'https://isthereanydeal.com/#/page:game/info?plain=serioussamhd',],
                'name' => 'Serious Sam HD',
            ],
        ];

        $dealService
            ->shouldReceive('fetchPrices')
            ->once()
            ->with('game-name')
            ->andReturn($dealResponse);

        $response = $this->json('GET', route('deals.show').'?name=game-name');

        $responseData = json_decode($response->getContent(), true);

        static::assertEquals($responseData, $dealResponse);
    }
}
