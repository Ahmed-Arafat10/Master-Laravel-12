<?php

namespace App\SOLID\Open_Closed_Principle;

class Triangle
{
    public $height;
    public $base;

    public function __construct($height, $base)
    {
        $this->height = $height;
        $this->$base = $base;
    }

    public function getArea()
    {
        return ($this->height * $this->base) / 2;
    }
}
