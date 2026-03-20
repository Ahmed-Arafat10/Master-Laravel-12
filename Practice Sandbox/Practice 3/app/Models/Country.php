<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public function posts()
    {
        /*
         Countries -> User -> Posts
        - this is the relation
        - to do that we first pass the `posts` model,  then intermediary table (`users` model)
        - then pass FK of intermediary table (`users` model) [you pass this parameter if you didn't follow Laravel convention]
        - then pass FK of `posts` model [you pass this parameter if you didn't follow Laravel convention]
         */
        return $this->hasManyThrough('App\Models\Post', 'App\Models\User', 'country_id', 'user_id');

    }
}
