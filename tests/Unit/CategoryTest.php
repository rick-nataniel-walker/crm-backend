<?php

namespace Tests\Unit;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function testFethCategories()
    {
        $this->withoutExceptionHandling();
        Category::factory()->count(2)->create();
        $response = $this->get("api/categories");
        $response->assertStatus(200);
    }

    public function testCreateCategory() {
        $this->withoutExceptionHandling();
        $data = [
            "name" => fake()->word()
        ];

        $response = $this->post("api/categories", $data);
        $category = Category::first();

        $response->assertStatus(201);

        $response->assertExactJson((
                new CategoryResource($category)
            )->response()->getData(true)
        );
    }
}
