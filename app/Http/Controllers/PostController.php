<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequests\PostStoreRequest;
use App\Http\Requests\PostRequests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        $posts = Post::orderBy('publish_date', 'desc')->paginate(10);
        return PostResource::collection($posts);
    }
    public function store(PostStoreRequest $request): JsonResponse
    {
        $this->authorize('create', Post::class);
        $validatedData = $request->validated();
        $validatedData['publish_date'] = Carbon::now()->toDateString();
        $post = auth()->user()->posts()->create($validatedData);
        return response()->json(['message'=>'post created successfully','post'=> new PostResource($post)], 201);
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
