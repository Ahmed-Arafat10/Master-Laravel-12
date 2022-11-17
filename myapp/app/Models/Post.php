<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // use HasFactory;

    // to change default table name
    protected $table = 'posts'; // by default is name of class in lowercase + `s` at end
    // then PostAdmin class will have a table by default called --> postadmins
    //protected $table = '__Post';

    // protected $primaryKey = 'post_id';// by default is `id`

    // by default this array is empty, so you have to add columns you want to fill their values
    protected $fillable = [
        'title',
        'content'
    ];

}
