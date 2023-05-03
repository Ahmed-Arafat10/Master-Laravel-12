<?php

namespace App\SOLID\Single_Responsibility_Principle;

class JsonExport implements SaleReportFormat
{
    public static function export($salesData)
    {
        return 'json format';
    }
}
