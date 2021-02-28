<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateListItemRequest;
use App\Models\GameList;
use App\Models\GameStatus;
use App\Models\ListItem;
use App\Services\Game\GameService;
use Auth;
use Exception;

class ListItemController extends ApiController
{
    /**
     * @var GameService
     */
    private $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function create(CreateListItemRequest $request, GameList $list)
    {
        $item = ListItem::where([
            'game_id' => $request->game_id,
        ])->first();

        if (!$item instanceof ListItem) {
            $game = $this->gameService->fetchById($request->game_id);

            $item = ListItem::create([
                'name' => $game->name,
                'game_id' => $request->game_id
            ]);
        }

        if ($list->listItems->contains($item)) {
            throw new Exception('Game already in the list', 400);
        }

        $list->listItems()->save($item);

        return $this->successResponse($list->refresh());
    }

    public function show(int $id)
    {
        $item = ListItem::where([
            'user_id' => Auth::id(),
            'uuid' => $id
        ]);

        return $this->successResponse($item);
    }

    public function destroy(ListItem $item, GameList $gameList)
    {
        $item->delete();

        return $this->successResponse($gameList->refresh(), null, 204);
    }
}
