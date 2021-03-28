<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class FollowerUser extends Model
{
    protected $table = 'follower_user';

    use HasFactory;

    public function activities()
    {
        return $this->hasMany(Activity::class, 'user_id', 'user_id');
    }
}
