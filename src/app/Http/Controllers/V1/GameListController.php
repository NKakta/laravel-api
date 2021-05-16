<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateGameListRequest;
use App\Http\Requests\CreateListItemRequest;
use App\Models\Activity;
use App\Models\GameList;
use App\Models\ListItem;
use App\Services\Activity\ActivityService;
use Auth;

class GameListController extends ApiController
{
    /**
     * @var ActivityService
     */
    private $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    /**
     * @OA\Get(
     *     path="api/v1/lists",
     *     description="Get game lists",
     *     summary="Get game list",
     *     security={{"BearerAuth": {}}},
     *     tags={"Game Lists"},
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
        $userId = Auth::id();

        $lists = GameList::where(['user_id' => $userId])
            ->orderBy('created_at')
            ->get();

        return $this->successResponse($lists);
    }

    /**
     * @OA\Post(
     *     path="api/v1/lists",
     *     description="Create game list",
     *     summary="Create game list",
     *     security={{"BearerAuth": {}}},
     *     tags={"Game Lists"},
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
    public function store(CreateGameListRequest $request)
    {
        $list = GameList::create($request->validated());

        $this->activityService->create(
            Activity::ACTION_LIST_CREATED,
            [
                'list_name' => $list->name
            ]
        );

        return $this->successResponse($list);
    }

    /**
     * @OA\Get(
     *     path="api/v1/lists/{list}",
     *     description="Create game list",
     *     summary="Create game list",
     *     security={{"BearerAuth": {}}},
     *     tags={"Game Lists"},
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
    public function show(GameList $list)
    {
        return $this->successResponse($list);
    }


    /**
     * @OA\Post(
     *     path="api/v1/lists/{list}",
     *     description="Update game list",
     *     summary="Update game list",
     *     security={{"BearerAuth": {}}},
     *     tags={"Game Lists"},
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
    public function update(CreateGameListRequest $request, GameList $list)
    {
        $list->update($request->validated());

        return $this->successResponse($list);
    }

    /**
     * @OA\Delete(
     *     path="api/v1/lists/{list}",
     *     description="Delete game list",
     *     summary="Delete game list",
     *     security={{"BearerAuth": {}}},
     *     tags={"Game Lists"},
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
     *         )
     *     )
     * )
     */
    public function destroy(GameList $list)
    {
        $list->delete();

        return $this->successResponse([], null, 204);
    }
}
