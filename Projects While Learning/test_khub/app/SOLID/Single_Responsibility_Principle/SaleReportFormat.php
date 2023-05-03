<?php

namespace App\SOLID\Single_Responsibility_Principle;

interface SaleReportFormat
{
    public static function export($salesData);
}
