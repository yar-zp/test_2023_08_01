<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Foundation\Application;
use \Illuminate\Http\Response;
use \Illuminate\Contracts\Foundation\Application as ContrApp;
use \Illuminate\Contracts\Routing\ResponseFactory;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($postId): Collection
    {
        return Comment::where('post_id', $postId)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($postId, StoreCommentRequest $request): Comment
    {
        $parent_id = $request->get('parent_id', null);

        $comment = new Comment();
        $comment->comment = $request->get('comment');
        $comment->author = $request->get('author');
        $comment->post_id = $postId;
        $comment->parent_id = $parent_id;
        $comment->path = '';
        $comment->save();

        $path = '/' . $comment->id;
        if ($parent_id !== null) {
            /** @var Comment $parentComment */
            $parentComment = Comment::find($parent_id);
            $path = $parentComment->path . $path;
        }
        $comment->path = $path;
        $comment->save();

        return $comment;
    }

    /**
     * Display the specified resource.
     */
    public function show($postId, Comment $comment): Comment
    {
        return $comment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($postId, UpdateCommentRequest $request, Comment $comment): Comment
    {
        $comment->comment = $request->get('comment');
        $comment->update();
        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($postId, Comment $comment): Application|Response|ContrApp|ResponseFactory
    {
        Comment::query()->where('path','like','%/'.$comment->id.'/%')->delete();
        $comment->delete();
        return response('', 204);
    }
}
