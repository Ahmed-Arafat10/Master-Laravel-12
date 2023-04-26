<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    public function user()
    {
        // eloquent will assume that the name of the FK in this table will be the name of this
        // method + '_id' so the result will be = 'user_id'
        return $this->belongsTo(\App\Models\User::class);
    }

    public function userhhh()
    {
        // as the name of this function will generate a 'userhhh_id' FK column name, we have to specify
        // FK name as the second parameter
        // & the third parameter is the name of PK coumn in 'user' table (by default eloquen assumes it is `id`)
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
