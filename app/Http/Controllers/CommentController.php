<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComentRequests\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentStoreRequest $request)
    {
        $this->authorize('create', Comment::class);

        $validatedData = $request->validated();
        $userId = auth()->user()->id;
        $validatedData['user_id'] = $userId;
        $comment = Comment::create($validatedData);
        return response()->json(['message' => 'Comment created successfully','comment' => new CommentResource($comment)], 201);
    }


    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
