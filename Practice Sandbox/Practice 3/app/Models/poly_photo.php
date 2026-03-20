<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poly_photo extends Model
{
    use HasFactory;

    protected $fillable = ['path'];

    public function imageable()
    {
        return $this->morphTo();
    }
}
