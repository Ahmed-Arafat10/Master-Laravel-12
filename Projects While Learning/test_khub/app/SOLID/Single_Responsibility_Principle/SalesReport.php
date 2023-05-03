<?php

namespace App\SOLID\Single_Responsibility_Principle;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SalesReport
{
    private Collection $sales;

    /**
     * @param $startDate
     * @param $endDate
     * @return $this
     */
    public function between($startDate, $endDate): SalesReport
    {
        $this->sales = DB::table('sales')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->get();
        return $this;
    }

    // OCP Method

    /**
     * @param SaleReportFormat $format
     * @return mixed
     */
    public function export(SaleReportFormat $format)
    {
        return $format->export($this->sales);
    }

    public static function forMonth($month)
    {
        //
    }

    public static function forYear($year)
    {
        //
    }

    //    public function pdfExport($sales)
//    {
//        return 'pdf format';
//    }
//
//    public function jsonExport($sales)
//    {
//        return 'json format';
//    }
//
//    public function csvExport($sales)
//    {
//        return 'csv format';
//    }
}
