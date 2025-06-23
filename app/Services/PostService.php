<?php

namespace App\Services;

use App\Http\mappers\PostMapper;
use App\Models\Post;
use App\Traits\FileUpload;
use App\Traits\StringsTrait;
use Illuminate\Http\Request;

class PostService
{
    use FileUpload;
    use StringsTrait;

    protected PostMapper $postMapper;

    public function create(Request $request)

    {
        $validatedRaw = $request->validate([
            "title" => "required|string",
            "slug" => "required|string|unique:posts,slug",
            "excerpt" => "nullable|string",
            "content" => "required|string",
            "authorId" => "required|integer|exists:users,id",
            "categoryId" => "required|integer|exists:categories,id",
            "postImg" => "required",
            "status" => "required|string|in:draft,published",
            "publishedAt" => "required|date",
        ]);

        $this->postMapper = new PostMapper();
        $mappedData = $this->postMapper->mapToRequest(new Request($validatedRaw));

        $imgType = gettype($mappedData["featured_image"]);

        if($imgType !== "string") {
            $storename = $this->uploadDoc($request, "postImg", env("POST_DIRECTORY"))["storename"];
            $mappedData["featured_image"] = $storename;
        }

        return Post::create($mappedData);
    }

    public function fetch()
    {
        return Post::all();
    }

    public function delete(Post $post) {
        $toDelete = $post;
        $toDelete->delete();
        return $post;
    }
}
