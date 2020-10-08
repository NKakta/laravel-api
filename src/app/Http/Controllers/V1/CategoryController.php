<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($id, $noteId, $categoryId)
    {
        if ($categoryId == 4)
        {
            return response()->json([
                'message' =>
                    'not found'
            ], 404);
        }
        return response()->json([
            'data' =>
            [
                'profileId' => $id,
                'noteId' => $noteId,
                'categoryId' => $categoryId
            ]
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create()
    {
        return response()->json([
            'data' => 'ok create'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        return response()->json([
            'data' => 'ok post'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id, $noteId, $categoryId)
    {
        if ($categoryId == 4)
        {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }
        return response()->json([
            'category' => 'text'
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function edit($id, $noteId, $categoryId)
    {
        if ($categoryId == 4)
        {
            return response()->json([], 404);
        }
        return response()->json([
            'message' => 'ok'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update($id, $noteId, $categoryId)
    {
        if ($categoryId == 4)
        {
            return response()->json([], 404);
        }
        return response()->json([
            'message' => 'new id'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id, $noteId, $categoryId)
    {
        if ($categoryId == 4)
        {
            return response()->json([], 404);
        }
        return response()->json([
            'message' => 'deleted'
        ], 204);
    }
}
