<?php

namespace App\SOLID\Single_Responsibility_Principle;
class CsvExport implements SaleReportFormat
{
    public static function export($salesData)
    {
        return 'csv format';
    }
}
