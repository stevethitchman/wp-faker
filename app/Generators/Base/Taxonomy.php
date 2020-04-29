<?php

namespace App\Generators\Base;

class Taxonomy
{
    public function __invoke()
    {
        $faker = \Faker\Factory::create('en_GB');

        return $faker->text(20);
    }
}
