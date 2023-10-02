Example #1
````php
public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        CategoryProduct::truncate();
        Transaction::truncate();
        Product::truncate();
        Category::truncate();
        User::truncate();

        //User::flushEventListeners();

        User::factory(100)->create();
        Category::factory(100)->create();

        Product::factory(100)->create()->each(function ($product) {
            Category::all()->random(mt_rand(1, 5))->each(function ($cat) use ($product) {
                DB::table('category_product')->insert([
                    'category_id' => $cat->id,
                    'product_id' => $product->id
                ]);
            });
            // Or
            //$categories =  Category::all()->random(mt_rand(1, 5))->pluck('id');
            //$product->categories()->attach($categories);
        });
        Transaction::factory(100)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
````

- in database seeder if we want to disable event listener (not to send email for every fake created user)

````php
User::flushEventListeners();
````