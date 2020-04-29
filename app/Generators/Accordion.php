<?php

namespace App\Generators;

class Accordion
{
    public function __invoke()
    {
        $faker = \Faker\Factory::create('en_GB');

        return [
            'heading' => $faker->text(30),
            'content' => $faker->paragraph(3, true),
        ];
    }
}
