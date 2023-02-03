<?php

namespace App\Http\Controllers;

use App\Models\CarModels;
use App\Models\Cars;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = Posts::where('id', '>=', 4)->FirstOrFail();
        echo "<pre>";
        var_dump($res->id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show_carmodel($id)
    {
        $model = CarModels::findOrFail($id);
        //dd($model);
        //dd($model[0]['name']);
        //$cars = $model->getcars;
        dd($model->getcars);
    }

    public function show($id)
    {
        $car = Cars::findOrFail($id)->mymodels;
        //var_dump($car);
        foreach ($car as $c) {
            //echo $c . "<br>";
            echo $c->name . "<br>";
        }
        /*
         {"id":1,"car_id":1,"name":"x5","created_at":null,"updated_at":null}
         {"id":2,"car_id":1,"name":"x6","created_at":null,"updated_at":null}
         {"id":3,"car_id":1,"name":"x7","created_at":null,"updated_at":null}
         */
        return view('cars.show', [
            'cars' => $car
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
