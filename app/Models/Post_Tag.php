<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post_Tag extends Model
{
    protected $table = 'post_tags';

    protected $fillable = ['post_id', 'tag_id'];

    protected $casts = [
        'post_id' => 'int',
        'tag_id'  => 'int',
    ];
}