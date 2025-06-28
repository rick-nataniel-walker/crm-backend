<?php

namespace App\Services;

use App\Http\mappers\PostMapper;
use App\Models\Post;
use App\Models\PostTag;
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
        $mappedData = $this->validateData($request);
        $tags = $request->tags;
        $post = Post::create($mappedData);

        if (is_array($tags)) {
            $post->tags()->attach($tags);
        }
        return $post;
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

    public function update(Request $request, Post $post)
    {
        $mappedData = $this->validateData($request);
        $tags = $request->tags;
        if (is_array($tags)) {
            $post->tags()->sync($tags);
        }
        if ($post->update($mappedData)) return $post;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function validateData(Request $request): array
    {
        $validatedRaw = $request->validate([
            "title" => "required|string",
            "slug" => "required|string",
            "excerpt" => "nullable|string",
            "content" => "required|string",
            "authorId" => "required|integer|exists:users,id",
            "categoryId" => "required|integer|exists:categories,id",
            "postImg" => "sometimes",
            "status" => "required|string|in:draft,published",
            "publishedAt" => "sometimes|date",
        ]);

        $this->postMapper = new PostMapper();
        $mappedData = $this->postMapper->mapToRequest(new Request($validatedRaw));

        if($mappedData["featured_image"]!==null) {
            $imgType = gettype($mappedData["featured_image"]);

            if ($imgType !== "string") {
                $storename = $this->uploadDoc($request, "postImg", env("POST_DIRECTORY"))["storename"];
                $mappedData["featured_image"] = $storename;
            }
        } else {
            unset($mappedData["featured_image"]);
        }
        return $mappedData;
    }
}
