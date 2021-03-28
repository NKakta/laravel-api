<?php
declare(strict_types=1);

namespace App\Services\User;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function searchByName(string $name)
    {
        return User::where(function ($query) use ($name) {
            $query->where('name', 'LIKE', "%$name%")
                ->orWhere('email', 'LIKE', "%$name%");
        })->get();
    }

}
