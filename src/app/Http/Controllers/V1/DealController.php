<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Services\Deal\DealService;
use Illuminate\Http\Request;

class DealController extends ApiController
{
    /**
     * @var DealService
     */
    private $dealService;

    public function __construct(DealService $dealService)
    {
        $this->dealService = $dealService;
    }

    public function show(Request $request)
    {
        $name = $request->query('name');

        return $this->dealService->fetchPrices($name);
    }
}
