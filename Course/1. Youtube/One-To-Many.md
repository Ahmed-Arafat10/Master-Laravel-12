````php
 public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('founded');
            $table->longText('description');
            $table->timestamps();
        });
    }
````

````php
  public function up()
    {
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('car_id')->unsigned();
            $table->string('name');
            $table->timestamps();
            $table->foreign('car_id')
                ->references('id')
                ->on('cars')
                ->onDelete('cascade');
        });
    }
````

````php
php artisan mak:contoller --resourse CarController 
````

- route file

````php
Route::resource('cars', \App\Http\Controllers\CarController::class);

Route::get('/getcarfrommodel/{id}', [\App\Http\Controllers\CarController::class, 'show_carmodel']);
````

- car model

````php
    public function mymodels()
    {
        // again eloquent use the name of the current model + '_id' = 'cars_id' as the FK column
        // in car models table, but since the FK column name is 'car_id' not 'cars_id' we have to add the second parameter as the nam of FK column
        return $this->hasMany(CarModels::class, 'car_id');
    }
````

- CarModel model file

````php
    public function getcars()
    {
        return $this->belongsTo(
            Cars::class,
            'car_id'
        );
    }
````

- carcontroller function to get car data using model (inverse relationship)

````php
public function show_carmodel($id)
    {
        $model = CarModels::findOrFail($id);
        //dd($model);
        //dd($model[0]['name']);
        //$cars = $model->getcars;
        dd($model->getcars);
    }
````

- carcontroller function to get car model of a car

````php
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
````

- `car/show.blade.php` file

````php
<h1>Hello World</h1>

@foreach($cars as $c )
    {{ $c->name }}
@endforeach
````
