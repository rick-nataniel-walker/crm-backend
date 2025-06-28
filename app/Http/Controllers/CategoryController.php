<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Get all posts",
     *     @OA\Response(response=200, description="Successful operation")
     * )
     */

    public function index()
    {
        $resource = $this->categoryService->fetch();
        return CategoryResource::collection($resource);
    }

    public function store(Request $request)
    {
        $category = $this->categoryService->create($request);
        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category)
    {
        $updated = $this->categoryService->update($request, $category);
        return new CategoryResource($updated);
    }

    public function destroy(Category $category) {
        $deleted = $this->categoryService->delete($category);
        return new CategoryResource($deleted);
    }
}
