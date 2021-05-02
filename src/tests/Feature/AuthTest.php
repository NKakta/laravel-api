<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    /** @test */
    public function authorized_user_able_to_find(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        /** @var User $user */
        $user = User::find(UserSeeder::USER_ID_2);

        $response = $this->json('GET', route('user.search'),['name' => 'user']);

        $this->assertJsonResponse($response, [$user->toArray()]);
    }

    /** @test */
    public function authorized_user_able_to_find_nothing(): void
    {
        Passport::actingAs(User::find(1), ['*']);

        $response = $this->json('GET', route('user.search'),['name' => 'does-not-exist'],);

        $this->assertJsonResponse($response, []);
    }
}
