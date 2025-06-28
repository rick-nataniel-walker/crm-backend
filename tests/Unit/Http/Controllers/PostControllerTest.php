<?php

namespace Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    Use RefreshDatabase;
    public function testCreatePost()
    {

        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $category = Category::factory()->create();
        // Define post data
        $postData = [
            'title' => fake()->sentence,
            'slug' => fake()->word,
            'excerpt' => fake()->sentence,
            'content' => fake()->sentence,
            'authorId' => $user->id,
            'categoryId' => $category->id,
            'postImg' => fake()->sentence,
            'status' => 'draft',
            'publishedAt' => now(),
        ];


        $response = $this->post("api/posts", $postData);

        $response->assertStatus(201);

        $post = Post::first();

        // Assert that the post was created
        $this->assertDatabaseHas('posts', [
            'title' => $postData["title"],
            'content' => $postData['content'],
        ]);

        $response->assertExactJson(
            (new PostResource($post))->response()->getData(true)
        );
    }

    public function testPostWithImageUpload()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        Storage::fake('public');

        // Prepare test data with an uploaded image
        $file = UploadedFile::fake()->image('post-image.jpg');

        $postData = [
            'title' => 'Post with image',
            'slug' => 'post-with-image',
            'excerpt' => 'This is an excerpt.',
            'content' => 'This is the full content.',
            'authorId' => $user->id,
            'categoryId' => $category->id,
            'postImg' => $file,
            'status' => 'published',
            'publishedAt' => Carbon::parse(now()->toISOString())->format('Y-m-d H:i:s')
        ];

        $response = $this->patch('/api/posts', $postData);

        $post = Post::first();

        $response->assertStatus(201);
        $response->assertExactJson(
            (new PostResource($post))->response()->getData(true)
        );

        // Assert the image was stored
        $response->assertJson('data.postImg');

        // Assert post was inserted into DB (optional but good practice)
        $this->assertDatabaseHas('posts', [
            'title' => $postData['title'],
            'slug' => $postData['slug'],
        ]);
    }

    public function testUpdatePost()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $post = Post::factory()->create();
        Storage::fake('public');

        // Prepare test data with an uploaded image
        $file = UploadedFile::fake()->image('post-image.jpg');

        $postData = [
            'title' => 'Post with image',
            'slug' => 'post-with-image',
            'excerpt' => 'This is an excerpt.',
            'content' => 'This is the full content.',
            'authorId' => $user->id,
            'categoryId' => $category->id,
            'postImg' => $file,
            'status' => 'published',
            'publishedAt' => Carbon::parse(now()->toISOString())->format('Y-m-d H:i:s')
        ];

        $response = $this->patchJson("/api/posts/$post->id", $postData);

        $response->assertStatus(200);
        $response->assertExactJson(
            (new PostResource($post))->response()->getData(true)
        );

        // Assert post was inserted into DB (optional but good practice)
        $this->assertDatabaseHas('posts', [
            'title' => $postData['title'],
            'slug' => $postData['slug'],
        ]);
    }

    public function testCreatePostWithTags()
    {

        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $category = Category::factory()->create();
        // Define post data
        $postData = [
            'title' => fake()->sentence,
            'slug' => fake()->word,
            'excerpt' => fake()->sentence,
            'content' => fake()->sentence,
            'authorId' => $user->id,
            'categoryId' => $category->id,
            'postImg' => fake()->sentence,
            'status' => 'draft',
            'publishedAt' => now(),
            'tags' => [1,2],
        ];


        $response = $this->post("api/posts", $postData);

        $response->assertStatus(201);

        $post = Post::first();
        $post_tag = PostTag::first();

        // Assert that the post was created
        $this->assertDatabaseHas('posts', [
            'title' => $postData["title"],
            'content' => $postData['content'],
        ]);

        $this->assertDatabaseHas("post_tag",[
            "post_id" => $post->id,
            "tag_id" => $postData["tags"][0],
        ]);

        $response->assertExactJson(
            (new PostResource($post))->response()->getData(true)
        );
    }

}
