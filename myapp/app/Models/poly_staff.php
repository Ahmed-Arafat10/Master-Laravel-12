<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poly_staff extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function image()
    {
        return $this->morphMany(poly_photo::class, 'imageable');
    }

}
