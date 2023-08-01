<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    const POST_ID = 1;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->getCommentList();
        $parentId = $this->addComment(null);
        $this->addComment($parentId);
        $this->editComment($parentId);
        $this->deleteComment($parentId);
    }

    public function getCommentList() : void
    {
        $response = $this->get('/api/posts/'.self::POST_ID.'/comments');
        $response->assertStatus(200);
        $response->assertJsonIsArray();
    }

    public function addComment(?int $parentId): int
    {
        $data = [
            'comment' => 'Lorem Ipsum',
            'author' => 'some author',
        ];
        if ($parentId) {
            $data['parent_id'] = $parentId;
        }
        $response = $this->post('/api/posts/'.self::POST_ID.'/comments', $data);
        $response->assertStatus(201);
        $response->assertJsonIsObject();

        $content = $response->getContent();
        $obj = json_decode($content);
        return $obj->id;
    }

    public function editComment($commentId): void
    {
        $data = [
            'comment' => 'edited comment'
        ];
        $response = $this->put('/api/posts/'.self::POST_ID.'/comments/'.$commentId, $data);
        $response->assertStatus(200);
        $response->assertJsonIsObject();
    }

    public function deleteComment($commentId): void
    {
        $response = $this->delete('/api/posts/'.self::POST_ID.'/comments/'.$commentId);
        $response->assertStatus(204);
    }
}
