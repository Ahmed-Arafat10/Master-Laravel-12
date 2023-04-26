<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Posts;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // we specify that this factory will be executed in the post model
        Posts::factory(100)->create();
        // you can override the factory written for a column if you want
        Posts::factory()->create([
            'body' => 'all created records will have the same body'
        ]);
    }
}
