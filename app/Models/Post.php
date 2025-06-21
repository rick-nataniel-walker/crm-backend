<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    Use HasFactory;
    protected $fillable = [
        "title",
        "slug",
        "excerpt",
        "content",
        "author_id",
        "category_id",
        "featured_image",
        "status",
        "published_at"
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return  $this->belongsTo(User::class, "author_id");
    }
}
