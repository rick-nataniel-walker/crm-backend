<?php

namespace Tests\Unit;

use App\Http\Resources\TagResource;
use App\Models\Tag;
use Tests\TestCase;

class TagsControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function testFethTags()
    {
        $this->withoutExceptionHandling();
        Tag::factory()->count(2)->create();
        $response = $this->get("api/tags");
        $response->assertStatus(200);
    }

    public function testCreateTag() {
        $this->withoutExceptionHandling();
        $data = [
            "name" => fake()->word()
        ];

        $response = $this->post("api/tags", $data);
        $tag = Tag::first();

        $response->assertStatus(201);

        $response->assertExactJson((
        new TagResource($tag)
        )->response()->getData(true)
        );
    }
}
