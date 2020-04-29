<?php

namespace App\Generators;

class Hero
{
    public function __invoke()
    {
        $faker = \Faker\Factory::create('en_GB');
        $faker->addProvider(new \App\Providers\WordpressImage($faker));

        $styles = ['default', 'text', 'image-right', 'image-left'];
        $style = $styles[array_rand($styles)];

        return [
            'style' => $style,
            'slides' => repeater(Slide::class, $faker->numberBetween(1, 5)),
            'image' => $faker->wpImage,
            'heading' => $faker->text(20),
        ];
    }
}