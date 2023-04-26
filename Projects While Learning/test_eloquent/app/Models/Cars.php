<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'name',
            'founded',
            'description'
        ];

    public function mymodels()
    {
        // again eloquent use the name of the current model + '_id' = 'cars_id' as the FK column
        // in car models table, but since the FK column name is 'car_id' not 'cars_id' we have to add the second parameter as the nam of FK column
        return $this->hasMany(CarModels::class, 'car_id');
    }
}
