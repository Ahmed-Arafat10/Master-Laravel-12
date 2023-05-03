<?php

namespace App\SOLID\Open_Closed_Principle;

class Rectangle implements Shape
{
    public $height;
    public $width;

    public function __construct($height,$width)
    {
        $this->height = $height;
        $this->width = $width;
    }

    public function area()
    {
        return $this->height * $this->width;
    }
}
