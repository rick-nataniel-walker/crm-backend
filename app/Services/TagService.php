<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagService
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required|string"
        ]);

        return Tag::create($validatedData);
    }

    public function fetch(): \Illuminate\Database\Eloquent\Collection
    {
        return Tag::all();
    }

    public function update(Request $request, Tag $tag): ?Tag
    {
        $validatedData = $request->validate([
            "name" => "required|string"
        ]);

        if($tag->update($validatedData)) {
            return $tag;
        }else return null;
    }

    public function delete(Tag $tag): Tag
    {
        $toDelete = $tag;
        $toDelete->delete();
        return $tag;
    }
}
