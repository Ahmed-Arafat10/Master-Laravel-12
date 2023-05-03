<?php

namespace App\SOLID\Open_Closed_Principle;

class Circle implements Shape
{
    public $radius;
    public function __construct($radius)
    {
        $this->radius = $radius;
    }

    public function area()
    {
        return $this->radius * $this->radius * pi();
    }
}
