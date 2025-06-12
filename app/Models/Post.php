<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
