<?php
declare(strict_types=1);

namespace App\Services\User;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowerService
{
    public function getFollowersForUser()
    {
        return Auth::user()->followers()->get();
    }

    public function getFollowingForUser()
    {
        return Auth::user()->followings()->get();
    }

    public function follow(string $userId)
    {
        Auth::user()
            ->followers()
            ->attach(
                User::where(['uuid' => $userId])->first()
            );

        return true;
    }

    public function unfollow(string $userId)
    {
        Auth::user()
            ->followers()
            ->detach(
                User::where(['uuid' => $userId])->first()
            );

        return true;
    }

    public function getNewsFeed()
    {
        /** @var User $user */
        $user = Auth::user();

        $activities = Activity::leftJoin('follower_user', function($join) {
            $join->on('activities.user_id', '=', 'follower_user.user_id');
        })
            ->select([
                'uuid',
                'game_id',
                'action',
                'data',
                'cover_url',
                'activities.created_at',
                'activities.updated_at'
            ])
            ->where('follower_user.user_id', '=', $user->id)
            ->orderBy('activities.created_at')
            ->get();

        return $activities;
    }

}
