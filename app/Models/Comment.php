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

class Comment extends Model
{
    use HasFactory;
    use Filterable;
    use AsSource;
    use Chartable;

    protected $fillable = [
        "user_id",
        "text",
        "post_id",
    ];

    protected $allowedSorts = [
        'id',
        'user_id',
        'text',
        'post_id'
    ];

    protected $allowedFilters = [
        'id'         => Where::class,
        'text'      => Like::class,
        'updated_at' => WhereDateStartEnd::class,
        'created_at' => WhereDateStartEnd::class,
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
