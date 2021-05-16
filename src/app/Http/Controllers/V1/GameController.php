<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Requests\SearchGameRequest;
use App\Services\Game\GameService;
use App\Http\Controllers\ApiController;
use App\Services\Review\ReviewService;

class GameController extends ApiController
{
    /**
     * @var GameService
     */
    private $gameService;

    /**
     * @var ReviewService
     */
    private $reviewService;

    public function __construct(GameService $gameService, ReviewService $reviewService)
    {
        $this->gameService = $gameService;
        $this->reviewService = $reviewService;
    }

    /**
     * @OA\Get(
     *     path="api/v1/games/search",
     *     description="Search game",
     *     summary="Search game",
     *     security={{"BearerAuth": {}}},
     *     tags={"Games"},
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
    public function search(SearchGameRequest $request)
    {
        $game = $this->gameService->fetchByName($request->name);

        return $this->successResponse($game);
    }

    /**
     * @OA\Get(
     *     path="api/v1/game/{id}",
     *     description="Show game",
     *     summary="Show game",
     *     security={{"BearerAuth": {}}},
     *     tags={"Games"},
     *     @OA\Parameter(name="id", in="path", required=True),
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
    public function show(int $id)
    {
        $game = $this->gameService->fetchById($id);

        return $this->successResponse($game);
    }

    /**
     * @OA\Get(
     *     path="api/v1/games/popular",
     *     description="Fetch popular games",
     *     summary="Fetch popular games",
     *     security={{"BearerAuth": {}}},
     *     tags={"Games"},
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
    public function showPopular()
    {
        $list = $this->gameService->fetchPopular();

        return $this->successResponse($list);
    }

    /**
     * @OA\Get(
     *     path="api/v1/game/{id}/reviews",
     *     description="Fetch popular games",
     *     summary="Fetch popular games",
     *     security={{"BearerAuth": {}}},
     *     tags={"Games"},
     *     @OA\Parameter(name="id", in="path", required=True),
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
    public function getReviewInfo(int $id)
    {
        $info = $this->reviewService->getReviewsForGame($id);

        return $this->successResponse($info, null, 200);
    }
}
