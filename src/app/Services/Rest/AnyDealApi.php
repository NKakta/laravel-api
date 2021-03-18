<?php
declare(strict_types=1);

namespace App\Services\Rest;

use GuzzleHttp\Client;

class AnyDealApi
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => env('ANY_DEAL_BASE_URI', '')]);
        $this->apiKey = env('ANY_DEAL_API_KEY', '');
    }

    public function searchDeals(string $name)
    {
        if (empty($name)) {
            return [];
        }

        $response = $this->client->get('v02/search/search/', [
            'query' => [
                'key' => $this->apiKey,
                'q' => $name,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true)['data']['results'];
    }

    public function fetchPrices(string $plainNames)
    {
        if (empty($plainNames)) {
            return [];
        }

        $response = $this->client->get('v01/game/prices/', [
            'query' => [
                'key' => $this->apiKey,
                'plains' => $plainNames,
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true)['data'];
    }
}
