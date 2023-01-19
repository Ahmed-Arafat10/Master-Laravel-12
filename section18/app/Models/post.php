<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{

    protected $fillable = ['title', 'content', 'path'];
    public $directory = '/images/';
    use HasFactory;

    public function scopeThisIsAhmed($query)
    {
        return $query->orderBy('id', 'desc')->get();
    }


    public function getPathAttribute($value)
    {
        return $this->directory . $value;
    }

}
