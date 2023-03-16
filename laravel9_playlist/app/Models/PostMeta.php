<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'meta_description', 'meta_robots' , 'meta_keywords', 'post_id'
    ];

    # one meta belongs to one post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
