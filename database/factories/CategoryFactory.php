<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       // $factory->define(Category::class, function (Faker $faker) {
            return [
                'name'          =>  $this->faker->name,
                'description'   =>  $this->faker->text,
                'parent_id'     =>  1,
                'menu'          =>  1,
            ];
        //});
    }
}