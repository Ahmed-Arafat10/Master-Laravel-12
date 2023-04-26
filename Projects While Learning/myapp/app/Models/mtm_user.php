<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class mtm_user extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password'];

    public function mtm_role()
    {
        //return $this->belongsToMany("App\Models\mtm_Role", "mtm_role_user", "user_id");
        return $this->belongsToMany("App\Models\mtm_Role", "mtm_role_user", "user_id", "role_id");
    }
}
