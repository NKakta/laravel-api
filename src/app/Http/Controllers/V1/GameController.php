<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Game ;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $games = Game::all();

        return response()->view(
            'games',
            ['games' => $games],
            200
        );
//        return response()->json([
//            'data' => $games
//        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        /** @var Game $game */
        $game = Game::create($request->all());
        $game->user_id = Auth::id();
        $game->save();

        return response()->json([
            'data' => $game
        ], 200);
    }

    /**
     * Display the specified resource.
     * @param Game $game
     * @return JsonResponse
     */
    public function show(Game $game)
    {
        return response()->json([
            'data' => $game
        ], 200);
    }

    public function update(Request $request, Game $game)
    {
        $this->validate($request, [
            'title'     => 'required',
            'content'   => 'required'
        ]);

        $game->update($request->all());

        return response()->json([
            'data' => $game
        ], 200);
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return response()->json([],204);
    }

    public function displayFrontend(Game $game)
    {

        $game->delete();

        return response()->json([],204);
    }
}
