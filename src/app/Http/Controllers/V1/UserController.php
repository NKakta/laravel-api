<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\SearchUserRequest;
use App\Services\User\UserService;

class UserController extends ApiController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function search(SearchUserRequest $request)
    {
        $users = $this->userService->searchByName($request->name);

        return $this->successResponse($users);
    }
}
