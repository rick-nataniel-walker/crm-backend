<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\PostService;

class PostController extends Controller
{

    protected PostService $postService;

    /**
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }


    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get all posts",
     *     @OA\Response(response=200, description="Successful operation")
     * )
     */

    public function index()
    {
        $posts = $this->postService->fetch();
        return PostResource::collection($posts);
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Create a new post",
     *     description="Stores a new post in the database.",
     *     operationId="storePost",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "slug", "excerpt", "content", "author_id"},
     *             @OA\Property(property="title", type="string", example="My New Post"),
     *             @OA\Property(property="slug", type="string", example="my-new-post"),
     *             @OA\Property(property="excerpt", type="string", example="Short summary of the post."),
     *             @OA\Property(property="content", type="string", example="Full content of the post."),
     *             @OA\Property(property="author_id", type="integer", example=1),
     *             @OA\Property(property="category_id", type="integer", example=3),
     *             @OA\Property(property="featured_img", type="string", example="https://example.com/image.jpg"),
     *             @OA\Property(property="status", type="string", example="published"),
     *             @OA\Property(property="published_at", type="string", format="date-time", example="2025-06-08T10:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="My New Post"),
     *             @OA\Property(property="slug", type="string", example="my-new-post"),
     *             @OA\Property(property="excerpt", type="string", example="Short summary."),
     *             @OA\Property(property="content", type="string", example="Full post content."),
     *             @OA\Property(property="author_id", type="integer", example=1),
     *             @OA\Property(property="category_id", type="integer", example=3),
     *             @OA\Property(property="featured_img", type="string", example="https://example.com/image.jpg"),
     *             @OA\Property(property="status", type="string", example="published"),
     *             @OA\Property(property="published_at", type="string", format="date-time", example="2025-06-08T10:00:00Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request - Validation Error"
     *     )
     * )
     */
    public function store(Request $request) {
        $post = $this->postService->create($request);
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
