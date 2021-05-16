<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Services\User\FollowerService;
use Illuminate\Support\Facades\Auth;

class FollowerController extends ApiController
{
    /**
     * @var FollowerService
     */
    private $followerService;

    public function __construct(FollowerService $followerService)
    {
        $this->followerService = $followerService;
    }

    /**
     * @OA\Get(
     *     path="api/v1/user/followers",
     *     description="Get followers",
     *     summary="Get followers",
     *     security={{"BearerAuth": {}}},
     *     tags={"Followers"},
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
        $followers = $this->followerService->getFollowersForUser();

        return $this->successResponse($followers);
    }

    /**
     * @OA\Post(
     *     path="api/v1/user/follow/{userId}",
     *     description="Follow",
     *     summary="Follow",
     *     security={{"BearerAuth": {}}},
     *     tags={"Followers"},
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
    public function follow(string $userId)
    {
        $this->followerService->follow($userId);

        return $this->successResponse();
    }

    /**
     * @OA\Delete(
     *     path="api/v1/user/follow/{userId}",
     *     description="Unfollow",
     *     summary="Unfollow",
     *     security={{"BearerAuth": {}}},
     *     tags={"Followers"},
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
    public function unfollow(string $userId)
    {
        $this->followerService->unfollow($userId);

        return $this->successResponse();
    }

    /**
     * @OA\Get(
     *     path="api/v1/user/news-feed",
     *     description="Get news feed",
     *     summary="Get news feed",
     *     security={{"BearerAuth": {}}},
     *     tags={"Followers"},
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
    public function getNewsFeed()
    {
        /** @var User $user */
        $user = Auth::user();
        $feed = $this->followerService->getNewsFeed($user);

        return $this->successResponse($feed);
    }
}
