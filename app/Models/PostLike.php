<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostLike extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;
    use Chartable;

    protected $fillable = [
        "user_id",
        "post_id",
        "feedback_type"
    ];

    protected $allowedSorts = [
        'id',
        'user_id',
        'post_id',
        'feedback_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
