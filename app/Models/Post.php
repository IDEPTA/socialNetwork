<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Types\WhereDateStartEnd;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;
    use Chartable;

    protected $fillable = [
        "title",
        "text",
        "images",
        "user_id"
    ];

    protected $casts = [
        'images' => 'array',
    ];

    protected $allowedFilters = [
        'id'         => Where::class,
        'title'       => Like::class,
        'text'      => Like::class,
        'updated_at' => WhereDateStartEnd::class,
        'created_at' => WhereDateStartEnd::class,
    ];

    protected $allowedSorts = [
        'id',
        'title',
        'text',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function like()
    {
        return $this->hasMany(PostLike::class);
    }
}
