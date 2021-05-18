<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateReviewRequest;
use App\Models\Activity;
use App\Models\Review;
use App\Services\Activity\ActivityService;
use App\Services\Game\GameService;
use App\Services\Review\ReviewService;
use Illuminate\Support\Facades\Auth;

class ReviewController extends ApiController
{
    /**
     * @var ActivityService
     */
    private $activityService;

    /**
     * @var GameService
     */
    private $gameService;

    /**
     * ReviewController constructor.
     */
    public function __construct(
        ActivityService $activityService,
        GameService $gameService
    ) {
        $this->activityService = $activityService;
        $this->gameService = $gameService;
    }

    /**
     * @OA\Get(
     *     path="api/v1/reviews",
     *     description="Get reviews",
     *     summary="Get reviews",
     *     security={{"BearerAuth": {}}},
     *     tags={"Reviews"},
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
    public function index()
    {
        $userId = Auth::User()->id;

        $list = Review::where(['user_id' => $userId])
            ->orderBy('created_at')
            ->get();

        return $this->successResponse($list);
    }

    /**
     * @OA\Post(
     *     path="api/v1/reviews",
     *     description="Update review",
     *     summary="Update review",
     *     security={{"BearerAuth": {}}},
     *     tags={"Reviews"},
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
    public function store(CreateReviewRequest $request)
    {
        $review = Review::create($request->validated());
        $review->user = Auth::user();

        $game = $this->gameService->fetchById($request->game_id);

        $this->activityService->create(
            Activity::ACTION_REVIEW_CREATED,
            [
                'game_name' => $game->name,
                'positive' => $review->positive
            ],
            $game
        );

        return $this->successResponse($review);
    }

    /**
     * @OA\Get(
     *     path="api/v1/reviews/{review}",
     *     description="Update review",
     *     summary="Update review",
     *     security={{"BearerAuth": {}}},
     *     tags={"Reviews"},
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
    public function show(Review $review)
    {
        return $this->successResponse($review);
    }

    /**
     * @OA\Post(
     *     path="api/v1/reviews/{review}",
     *     description="Update review",
     *     summary="Update review",
     *     security={{"BearerAuth": {}}},
     *     tags={"Reviews"},
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
    public function update(CreateReviewRequest $request, Review $review)
    {
        $review->update($request->validated());

        return $this->successResponse($review);
    }

    /**
     * @OA\Delete (
     *     path="api/v1/reviews/{review}",
     *     description="Update review",
     *     summary="Update review",
     *     security={{"BearerAuth": {}}},
     *     tags={"Reviews"},
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
    public function destroy(Review $review)
    {
        $review->delete();

        return $this->successResponse([], null, 204);
    }
}
