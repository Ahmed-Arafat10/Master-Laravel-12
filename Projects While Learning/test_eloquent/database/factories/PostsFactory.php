<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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
}
