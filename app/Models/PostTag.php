<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        "post_id",
        "tag_id",
    ];
}
