<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "title" => $this->title,
            "slug" =>  $this->slug,
            "excerpt" =>  $this->excerpt,
            "content" =>  $this->content,
            "authorId" => $this->author_id,
            "categoryId" =>  $this->category_id,
            "postImg" =>  $this->featured_image,
            "status" =>  $this->status,
            "publishedAt" =>  Carbon::parse($this->published_at)->format('Y-m-d H:i:s')
        ];
    }
}
