<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Services\User\FollowerService;
use Illuminate\Http\Request;

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

    public function index()
    {
        $followers = $this->followerService->getFollowersForUser();

        return $this->successResponse($followers);
    }

    public function follow(string $userId)
    {
        $this->followerService->follow($userId);

        return $this->successResponse();
    }

    public function unfollow(string $userId)
    {
        $this->followerService->unfollow($userId);

        return $this->successResponse();
    }

    public function getNewsFeed()
    {
        $feed = $this->followerService->getNewsFeed();

        return $this->successResponse($feed);
    }
}
