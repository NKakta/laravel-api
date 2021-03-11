<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Request;

class StatusController extends ApiController
{
    public function update()
    {
        return 'ok';
    }
}
