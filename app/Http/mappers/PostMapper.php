<?php

namespace App\Http\mappers;

use Illuminate\Http\Request;

class PostMapper
{

    public function mapToRequest(Request $request)
    {
        $data = $request->all();
        return [
            "title"=>$data["title"],
            "slug" => $data["slug"],
            "excerpt" => $data["excerpt"],
            "content" => $data["content"],
            "author_id" => $data["authorId"],
            "category_id" => $data["categoryId"],
            "featured_image" => $data["postImg"],
            "status" => $data["status"],
            "published_at" => $data["publishedAt"],
        ];
    }
}
