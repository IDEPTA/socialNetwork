<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "text",
        "post_id",
    ];

    public function user()
    {
        $this->hasMany(User::class);
    }

    public function post()
    {
        $this->belongsTo(Post::class);
    }
}
