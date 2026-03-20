<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ztmp_user extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'name', 'email', 'password'
        ];

    public function ztemp_post()
    {
        return $this->hasMany("\App\Models\ztmp_post", "user_id");
    }

}
