<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Models\Activity;
use Auth;

class ActivityController extends ApiController
{
    public function index()
    {
        $userId = Auth::User()->uuid;

        $activities = Activity::where(['user_id' => $userId])
            ->orderBy('created_at')
            ->get();

        return $this->successResponse($activities);
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
