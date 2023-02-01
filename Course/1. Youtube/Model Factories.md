- factory model allows us to add thousands of fake generated records in the database
- this is hugely used while testing better than is better than seeders

````php
php artisan make:factory PostsFactory
````

````php
 public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence, // title will be unique
            'excerpt' => $this->faker->realText(50), // max number of characters are 50
            'body' => $this->faker->text(),
            'image_path' => $this->faker->imageUrl(640, 480), // width & height of the image
            'is_published' => 1,
            'min_to_read' => $this->faker->numberBetween(1, 10) // pick a number from range (1,10)
        ];
    }
````

- whenever you want to put your factory into work, you need to
  write a seeder for it specially `databaseseeder` that is already defined, like this

````php
  public function run()
    {
        // we specify that this factory will be executed in the post model
        Posts::factory(100)->create();
        // you can override the factory written for a column if you want
        Posts::factory()->create([
            'body' => 'all created records will have the same body'
        ]);
    }
````

- name of the factory must follow a convention, name of model class + `factory` word
  , so if I want to create a factory for `Posts.php` model class, I will name it
  `PostsFactory`