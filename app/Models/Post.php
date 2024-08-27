<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "text",
        "images",
        "user_id"
    ];
    protected $casts = [
        'images' => 'array',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function comment()
    {
        $this->hasMany(Comment::class);
    }
}
