<?php

namespace App\SOLID\Single_Responsibility_Principle;

class PdfExport implements SaleReportFormat
{
    public static function export($salesData)
    {
        return 'pdf format';
    }
}
