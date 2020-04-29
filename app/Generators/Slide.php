<?php

namespace App\Generators;

class Slide
{
    public function __invoke()
    {
        $faker = \Faker\Factory::create('en_GB');
        $faker->addProvider(new \App\Providers\WordpressImage($faker));

        return [
            'heading' => $faker->text(30),
            'image' => $faker->wpImage,
        ];
    }
}