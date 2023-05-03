<?php

namespace App\SOLID\Open_Closed_Principle;

use Exception;

class AreaCalculator
{
    public function totalArea(array $shapes)
    {
        $area = 0;
        foreach ($shapes as $shape) {
           if($shape instanceof Shape) $area += $shape->area();
           else throw new Exception( get_class($shape) . 'should implements App\SOLID\Open_Closed_Principle\Shape Interface');
        }
        return $area;
    }

    // Violates Open Closed Principle
    public function totalAreaWrong(array $shapes)
    {
        $area = 0;
        foreach ($shapes as $shape) {
            if($shape instanceof Rectangle) $area += $shape->height * $shape->width;
            if($shape instanceof Circle) $area += $area->radius * $area->radius * pi();
        }
        return $area;
    }
}
