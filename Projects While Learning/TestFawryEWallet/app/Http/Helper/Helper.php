<?php

namespace App\Http\Helper;

class Helper
{
    public static function getProducts()
    {
        $products = [
            [
                'name' => 'Pepsi',
                'qty' => 3,
                'price' => 10
            ],
            [
                'name' => 'Chepsi',
                'qty' => 5,
                'price' => 5
            ],
            [
                'name' => '7Up',
                'qty' => 10,
                'price' => 12
            ],
        ];
        return $products;
    }
}
