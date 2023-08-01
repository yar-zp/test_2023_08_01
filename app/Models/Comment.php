<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
//
//    private int $id;
//    private int $post_id = 0;
//    private string $comment = '';
//    private string $author = '';
//    private ?int $parent_id = null;
//    private string $path = '';

    protected $fillable = ['comment', 'author', 'parent_id'];
    protected $hidden = ['path'];

}
