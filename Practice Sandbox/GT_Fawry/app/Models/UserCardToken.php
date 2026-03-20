<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCardToken extends Model
{
    use HasFactory;

    protected $table = 'user_card_tokens';

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
