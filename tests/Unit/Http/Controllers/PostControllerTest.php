<?php

namespace Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
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
        // Define post data
        $postData = [
            'title' => fake()->sentence,
            'slug' => fake()->word,
            'excerpt' => fake()->sentence,
            'content' => fake()->sentence,
            'author_id' => fake()->numberBetween(1,10),
            'category_id' => fake()->numberBetween(1,10),
            'featured_image' => fake()->sentence,
            'status' => 'draft',
            'published_at' => now(),
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
        // Use fake storage to avoid affecting the real disk
        Storage::fake('public');

        // Prepare test data with an uploaded image
        $file = UploadedFile::fake()->image('post-image.jpg');

        $postData = [
            'title' => 'Post with image',
            'slug' => 'post-with-image',
            'excerpt' => 'This is an excerpt.',
            'content' => 'This is the full content.',
            'author_id' => fake()->numberBetween(1,10),
            'category_id' => fake()->numberBetween(1,10),
            'featured_image' => $file,
            'status' => 'published',
            'published_at' => Carbon::parse(now()->toISOString())->format('Y-m-d H:i:s')
        ];

        $response = $this->postJson('/api/posts', $postData);

        $post = Post::first();

        $response->assertStatus(201);
        $response->assertExactJson(
            (new PostResource($post))->response()->getData(true)
        );

        // Assert the image was stored
        $response->assertJson('data.featured_image');

        // Assert post was inserted into DB (optional but good practice)
        $this->assertDatabaseHas('posts', [
            'title' => $postData['title'],
            'slug' => $postData['slug'],
        ]);
    }

}
