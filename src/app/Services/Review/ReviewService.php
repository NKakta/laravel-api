<?php
declare(strict_types=1);

namespace App\Services\Review;

use App\Models\GameStatus;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
    public function getReviewsForGame(int $gameId)
    {
        $status = Review::where([
            'user_id' => Auth::user()->uuid,
            'game_id' => $id
        ])
        ->first();

        if (!$status instanceof GameStatus)
        {
            return GameStatus::STATUS_EMPTY;
        }

        return $status->status;
    }


}
