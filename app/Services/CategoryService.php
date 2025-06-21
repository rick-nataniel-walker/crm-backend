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
}
