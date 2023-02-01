<?php

namespace Database\Seeders;

use App\Models\Posts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => str_random(10),
            'role' => 2,
            'is_active' => 1,
            'email' => str_random(10) . '@gmail.com',
            'password' => bcrypt('secret')
        ]);
        $posts = [
            [
                'title' => 'post one',
                'excerpt' => 'summary of post one',
                'body' => 'body of post one',
                'image_path' => 'Empty',
                'is_published' => false,
                'min_to_read' => 2,
            ],
            [
                'title' => 'post two',
                'excerpt' => 'summary of post two',
                'body' => 'body of post two',
                'image_path' => 'Empty',
                'is_published' => false,
                'min_to_read' => 2,
            ]
        ];
        foreach ($posts as $key => $value) {
            Posts::create($value);
        }
    }

}
