<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poly_mtm_post extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function tags()
    {
        return $this->morphToMany(poly_mtm_tag::class, 'taggable', 'poly_mtm_taggables', null, 'tag_id');
        // second parameter is the name os pivot table `poly_mtm_taggable`
    }
}
