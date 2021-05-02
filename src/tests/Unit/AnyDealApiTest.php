<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Services\Rest\AnyDealApi;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Psr\Http\Message\StreamInterface;
use Tests\TestCase;
use GuzzleHttp\Client;

class AnyDealApiTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use WithFaker;

    /**
     * @var \Mockery\MockInterface
     */
    private $client;

    /**
     * @var AnyDealApi
     */
    private $anyDealApi;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = $this->mock(Client::class);
        $this->anyDealApi = new AnyDealApi();
        $this->anyDealApi->setClient($this->client);
    }

    /** @test */
    public function should_return_on_empty_name(): void
    {
        $result = $this->anyDealApi->searchDeals('');
        static::assertEquals($result, []);
    }

    /** @test */
    public function should_not_fetch_prices_on_empty_names(): void
    {
        $result = $this->anyDealApi->fetchPrices('');
        static::assertEquals($result, []);
    }

    /** @test */
    public function should_return_deals_when_searched(): void
    {
        $response = $this->mock(Response::class);

        $this->client
            ->shouldReceive('get')
            ->once()
            ->with('v02/search/search/', [
                'query' => [
                    'key' => '',
                    'q' => 'name',
                ]
            ])
            ->andReturn($response)
        ;

        $stream = $this->mock(StreamInterface::class);

        $response
            ->shouldReceive('getBody')
            ->once()
            ->andReturn($stream)
        ;

        $dealsResponse = ['data' => ['results' => ['value']]];

        $stream
            ->shouldReceive('getContents')
            ->once()
            ->andReturn(json_encode($dealsResponse))
        ;

        $result = $this->anyDealApi->searchDeals('name');

        static::assertEquals($result, ['value']);
    }

    /** @test */
    public function should_be_able_to_fetch_prices(): void
    {
        $response = $this->mock(Response::class);

        $this->client
            ->shouldReceive('get')
            ->once()
            ->with('v01/game/prices/', [
                'query' => [
                    'key' => '',
                    'plains' => 'name',
                ]
            ])
            ->andReturn($response)
        ;

        $stream = $this->mock(StreamInterface::class);

        $response
            ->shouldReceive('getBody')
            ->once()
            ->andReturn($stream)
        ;

        $dealsResponse = ['data' => 'value'];

        $stream
            ->shouldReceive('getContents')
            ->once()
            ->andReturn(json_encode($dealsResponse))
        ;

        $result = $this->anyDealApi->fetchPrices('name');

        static::assertEquals($result, 'value');
    }
}
