<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getQrCodeAttribute()
    {
        return $this->attributes['qr_code'] ? "<img width=\"50\" height=\"50\" src=\"{$this->attributes['qr_code']}\" >" : 'N/A';
    }
}
