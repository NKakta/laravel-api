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

    public function index()
    {
        $userId = Auth::id();

        $lists = GameList::where(['user_id' => $userId])
            ->orderBy('created_at')
            ->get();

        return $this->successResponse($lists);
    }

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

    public function show(GameList $list)
    {
        return $this->successResponse($list);
    }

    public function update(CreateGameListRequest $request, GameList $list)
    {
        $list->update($request->validated());

        return $this->successResponse($list);
    }

    public function destroy(GameList $list)
    {
        $list->delete();

        return $this->successResponse([], null, 204);
    }

    public function addItem(GameList $list, CreateListItemRequest $request)
    {
        ListItem::create($request->validated());

        return $this->successResponse([], null, 204);
    }
}
