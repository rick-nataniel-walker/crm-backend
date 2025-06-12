<?php

namespace App\Services;

use App\Models\Post;
use App\Traits\FileUpload;
use App\Traits\StringsTrait;
use Illuminate\Http\Request;

class PostService
{
    use FileUpload;
    use StringsTrait;

    public function create(Request $request)

    {
        $validatedData = $request->validate([
            "title" => "required|string",
            "slug" => "required",
            "excerpt" => "required|string",
            "content" => "required|string",
            "author_id" => "required|integer",
            "category_id" => "required|integer",
            "featured_image" => "required",
            "status" => "required|string",
            "published_at" => "required"
        ]);

        $imgType = gettype($validatedData["featured_image"]);

        if($imgType !== "string") {
            $storename = $this->uploadDoc($request, "featured_image", env("POST_DIRECTORY"))["storename"];
            $validatedData["featured_image"] = $storename;
        }

        return Post::create($validatedData);
    }
}
