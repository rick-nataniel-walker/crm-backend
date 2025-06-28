<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    protected TagService $tagService;

    /**
     * @param TagService $tagService
     */
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resource = $this->tagService->fetch();
        return TagResource::collection($resource);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $resource = $this->tagService->create($request);
        return new TagResource($resource);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $resource = $this->tagService->update($request, $tag);
        return new TagResource($resource);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $resource = $this->tagService->delete($tag);
        return new TagResource($resource);
    }
}
