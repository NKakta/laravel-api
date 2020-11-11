<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $profiles = Profile ::fetchAllByUserId(Auth::id());

        return response()->json([
            'data' => $profiles
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'nickname' => 'required',
        ]);

        /** @var Profile $profile */
        $profile = Profile ::create($request->all());
        $profile->user_id = Auth::id();
        $profile->save();

        return response()->json([
            'data' => $profile
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Profile $profile)
    {
        return response()->json([
            'data' => $profile
        ], 200);
    }

    public function update(Request $request, Profile $profile)
    {
        $request->validate([
            'address' => 'required',
            'nickname' => 'required',
        ]);

        $profile->update($request->all());

        return response()->json([
            'data' => $profile
        ], 200);
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();

        return response()->json([],204);
    }
}
