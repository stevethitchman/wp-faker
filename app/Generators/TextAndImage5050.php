<?php

namespace App\Generators;

class TextAndImage5050
{
    public function __invoke()
    {
        $faker = \Faker\Factory::create('en_GB');
        $faker->addProvider(new \App\Providers\WordpressImage($faker));

        $styles = ['right', 'left'];

        return [
            'coloured' => $faker->boolean(),
            'style' => $styles[array_rand($styles)],
            'heading' => $faker->text(30),
            'image' => $faker->wpImage,
            'content' => $faker->paragraph(3, true),
        ];
    }
}