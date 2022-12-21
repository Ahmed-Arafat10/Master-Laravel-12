<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ztmp_address extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
}
