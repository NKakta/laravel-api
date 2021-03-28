<?php
declare(strict_types=1);

namespace App\Services\Deal;

use App\Services\Rest\AnyDealApi;

class DealService
{
    /**
     * @var AnyDealApi
     */
    private $api;

    public function __construct(AnyDealApi $api)
    {
        $this->api = $api;
    }

    public function fetchDeals(string $name)
    {
        return $this->api->searchDeals($name);
    }

    private function addTitlesToPrices(array $prices, array $plains): array
    {
        $result = [];
        foreach ($plains as $plain) {
            if (isset($prices[$plain['plain']])) {
                $prices[$plain['plain']]['name'] = $plain['title'];
                $result[] = $prices[$plain['plain']];
            }
        }

        return $result;
    }

    private function getPlainsString(array $plains): string
    {
        $plainNames = [];
        foreach ($plains as $plain) {
            $plainNames []= $plain['plain'];
        }

        return implode(',', $plainNames);
    }

    public function fetchPrices(string $name)
    {
        $plains = $this->fetchDeals($name);

        $plainsString = $this->getPlainsString($plains);

        $prices = $this->api->fetchPrices($plainsString);

//        foreach ($prices as $key => $list) {
//            $list
//        }

        return $this->addTitlesToPrices($prices, $plains);
    }
}
