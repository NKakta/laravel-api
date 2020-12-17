<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $notes = Note::all();

        return response()->view(
            'notes',
            ['notes' => $notes],
            200
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        /** @var Note $note */
        $note = Note::create($request->all());
        $note->user_id = Auth::id();
        $note->save();

        return response()->json([
            'data' => $note
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Note $note)
    {
        return response()->json([
            'data' => $note
        ], 200);
    }

    public function update(Request $request, Note $note)
    {
        $this->validate($request, [
            'title'     => 'required',
            'content'   => 'required'
        ]);

        $note->update($request->all());

        return response()->json([
            'data' => $note
        ], 200);
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return response()->json([],204);
    }
}
