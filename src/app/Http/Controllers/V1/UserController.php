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

    /**
     * @OA\Get(
     *     path="api/v1/user/search",
     *     description="Search for users",
     *     summary="Search for users",
     *     security={{"BearerAuth": {}}},
     *     tags={"Users"},
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
    public function search(SearchUserRequest $request)
    {
        $users = $this->userService->searchByName($request->name);

        return $this->successResponse($users);
    }
}
