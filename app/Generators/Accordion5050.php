<?php

namespace App\Generators;

class Accordion5050
{
    public function __invoke()
    {
        $faker = \Faker\Factory::create('en_GB');

        return [
            'coloured' => $faker->boolean(),
            'heading' => $faker->text(30),
            'accordions' => repeater(Accordion::class, $faker->numberBetween(1, 5)),
        ];
    }
}