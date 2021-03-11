<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class StatusController extends ApiController
{
    public function update(Request $request, int $gameId)
    {
        return 'okay';
    }
}
