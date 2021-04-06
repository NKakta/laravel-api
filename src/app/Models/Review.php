<?php

namespace App\Models;

use App\Contracts\UuidInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model implements UuidInterface
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'positive', 'game_id'];
    
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
