<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $categorys = Category ::fetchAllByUserId(Auth::id());

        return response()->json([
            'data' => $categorys
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        /** @var Category $category */
        $category = Category ::create($request->all());
        $category->user_id = Auth::id();
        $category->save();

        return response()->json([
            'data' => $category
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Category $category)
    {
        return response()->json([
            'data' => $category
        ], 200);
    }

    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'title'     => 'required',
        ]);

        $category->update($request->all());

        return response()->json([
            'data' => $category
        ], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([],204);
    }
}
