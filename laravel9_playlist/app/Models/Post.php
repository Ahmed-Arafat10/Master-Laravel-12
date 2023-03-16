<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasOne;
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'excerpt', 'body', 'image_path', 'is_published', 'min_to_read', 'user_id'
    ];

    private $dir = '/images/';
    public function getImagePathAttribute($value)
    {
        return $this->dir . $value;
    }

    # Singular as each post will be related to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    # one post has one meta

    /**
     * @return HasOne
     */
    public function meta(): HasOne
    {
        return $this->hasOne(PostMeta::class);
    }
}
