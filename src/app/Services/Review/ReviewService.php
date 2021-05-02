<?php
declare(strict_types=1);

namespace App\Services\Review;

use App\Models\GameStatus;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
    public function getReviewsForGame(int $id)
    {
        $positive = Review::where([
            'game_id' => $id,
            'positive' => true
        ])
        ->groupBy('positive')
        ->count();

        $negative = Review::where([
            'game_id' => $id,
            'positive' => false
        ])
        ->groupBy('positive')
        ->count();

        $reviews = Review::where(['game_id' => $id])
        ->orderBy('created_at')
        ->get();

        return [
            'positiveCount' => $positive,
            'negativeCount' => $negative,
            'reviews' => $reviews
        ];
    }

    public function getReviewForGame(int $gameId)
    {
        return Review::where([
            'game_id' => $gameId,
            'user_id' => Auth::user()->id
        ])
        ->first();
    }


}
