<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;


class CategoryService
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|string"
        ]);

        return Category::create($validatedData);
    }

    public function fetch() {
        return Category::all();
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            "name" => "required|string"
        ]);

        if($category->update($validatedData)) {
            return $category;
        }else return null;
    }

    public function delete(Category $category) {
        $toDelete = $category;
        $toDelete->delete();
        return $category;
    }
}
