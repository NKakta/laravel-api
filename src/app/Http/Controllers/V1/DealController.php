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

    /**
     * @OA\Get(
     *     path="api/v1/deal/search",
     *     description="Search deals for games",
     *     summary="Fetches games from IsThereAnyDealApi",
     *     security={{"BearerAuth": {}}},
     *     tags={"Deals"},
     *     @OA\Parameter(name="name", in="query", required=True),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="int", example="200"),
     *             @OA\Property(property="success", type="bool", example="true"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example={}
     *             )
     *         ),
     *     )
     * )
     */
    public function show(Request $request)
    {
        $name = $request->query('name');

        return $this->dealService->fetchPrices($name);
    }
}
