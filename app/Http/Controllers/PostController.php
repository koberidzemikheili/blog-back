<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequests\PostStoreRequest;
use App\Http\Requests\PostRequests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        $posts = Post::paginate(10);
        return PostResource::collection($posts);
    }
    public function store(PostStoreRequest $request): JsonResponse
    {
        $this->authorize('create', Post::class);
        $validatedData = $request->validated();
        auth()->user()->posts()->create($validatedData);
        return response()->json(['message'=>'post created successfully']);
    }
    public function show(Post $post): PostResource
    {
        $post->increment('views');
        return new PostResource($post);
    }
    public function update(PostUpdateRequest $request, Post $post): JsonResponse
    {
        $this->authorize('update', $post);
        $validatedData = $request->validated();
        $post->update($validatedData);
        return response()->json(['message'=>'post updated successfully']);
    }
    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json(['message'=>'post deleted successfully']);
    }
}
