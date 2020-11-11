<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];


    public static function fetchAllByUserId(int $userId): ?Collection
    {
        return self::query()
            ->where('user_id', $userId)
            ->get()
            ;
    }
}
