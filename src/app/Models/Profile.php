<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'nickname'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }


    public static function fetchAllByUserId(int $userId): ?Collection
    {
        return self::query()
            ->where('user_id', $userId)
            ->get()
            ;
    }
}
