<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];// to treat this column as a timestamp

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

    public function GetUserDataFromPost()
    {
        return $this->belongsTo('App\Models\User', 'User_ID', 'id');
    }

    public function photos()
    {
        return $this->morphMany('App\Models\Photo', 'imageable');
    }
}
