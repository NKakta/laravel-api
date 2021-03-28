<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Models\Activity;
use App\Models\User;
use App\Services\Activity\ActivityService;
use App\Services\User\FollowerService;
use Illuminate\Support\Facades\Auth;

class ActivityController extends ApiController
{
    /**
     * @var FollowerService
     */
    private $followerService;
    /**
     * @var ActivityService
     */
    private $activityService;

    public function __construct(FollowerService $followerService, ActivityService $activityService)
    {
        $this->followerService = $followerService;
        $this->activityService = $activityService;
    }

    public function index()
    {
        $userId = Auth::User()->id;

        $activities = Activity::where(['user_id' => $userId])
            ->orderBy('created_at')
            ->get();

        return $this->successResponse($activities);
    }

    public function getUserActivity(string $userId)
    {
        /** @var User $user */
        $user = User::where(['uuid' => $userId])->first();

        $feed = $this->activityService->getActivities($user->id);

        return $this->successResponse($feed);
    }

    public function show(Activity $activity)
    {
        return $this->successResponse($activity);
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return $this->successResponse([], null, 204);
    }
}
