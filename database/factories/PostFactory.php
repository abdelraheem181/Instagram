<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Services\ImageFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'post_caption' => $this->faker->paragraph,
           // 'image_path' =>'uploads/'.$this->faker->image('public\storage\uploads', 800, 600, null, false),
           'image_path' => 'uploads/' . ImageFaker::create(
            storage_path('app/public/uploads'),
            600,
            600,
            public_path('Roboto-Regular.ttf')
        ),
        ];
    }
}
