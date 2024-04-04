<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{

    public function create(User $user): bool
    {
        return $user->can('create comments');
    }

    public function delete(User $user, Comment $comment): bool
    {
        return ($user->id === $comment->user_id && $user->can('delete comments')) || $user->hasRole('Admin');
    }

}
