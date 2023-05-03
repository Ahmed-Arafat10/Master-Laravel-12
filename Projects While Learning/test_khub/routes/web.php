<?php

use App\SOLID\Single_Responsibility_Principle\PdfExport;
use App\SOLID\Single_Responsibility_Principle\SalesReport;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('home', function () {
    return view('home');
})->name('HOME');

Route::get('/test/{id}/{name}', function ($id) {
    return $id;
})->name('TEST');



/*
|--------------------------------------------------------------------------
| SOLID Principle
|--------------------------------------------------------------------------
*/

Route::get('/getSales', function () {

    # Method 1 (SRP)
    # between should be static in this returning the query
    //$sales = SalesReport::between('1 jan 2022', '24 jan 2022');
    //return PdfExport::export($sales);
    //return CsvExport::export($sales);
    //return JsonExport::export($sales);

    # Method 2 (SRP & OCP)
    (new SalesReport)->between('1 jan 2022', '24 jan 2022')
        ->export(new PdfExport);

});


/*
|--------------------------------------------------------------------------
| SOLID Principle
|--------------------------------------------------------------------------
*/

use \App\SOLID\Open_Closed_Principle\AreaCalculator;
use \App\SOLID\Open_Closed_Principle\Circle;
use \App\SOLID\Open_Closed_Principle\Rectangle;
use \App\SOLID\Open_Closed_Principle\Triangle;

Route::get('/getArea', function () {

    return (new AreaCalculator)->totalArea([
        new Rectangle(10, 20),
        new Rectangle(20, 20),
        new Circle(10),
        new Triangle(30,40),
    ]);

});
