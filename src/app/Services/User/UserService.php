<?php
declare(strict_types=1);

namespace App\Services\User;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * @var FollowerService
     */
    private $followerService;

    /**
     * UserService constructor.
     */
    public function __construct(FollowerService $followerService)
    {
        $this->followerService = $followerService;
    }

    public function searchByName(string $name)
    {
        return User::where(function ($query) use ($name) {
            $query->where('name', 'LIKE', "%$name%")
                ->orWhere('email', 'LIKE', "%$name%");
        })->limit(10)->get();
    }

}
