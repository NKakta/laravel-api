<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\CreateReviewRequest;
use App\Models\Review;
use Auth;

class ReviewController extends ApiController
{
    public function index()
    {
        $userId = Auth::User()->uuid;

        $list = Review::where(['user_id' => $userId])
            ->orderBy('created_at')
            ->get();

        return $this->successResponse($list);
    }

    public function store(CreateReviewRequest $request)
    {
        $list = Review::create($request->validated());

        return $this->successResponse($list);
    }

    public function show(Review $review)
    {
        return $this->successResponse($review);
    }

    public function update(CreateReviewRequest $request, Review $review)
    {
        $review->update($request->validated());

        return $this->successResponse($review);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return $this->successResponse([], null, 204);
    }
}
