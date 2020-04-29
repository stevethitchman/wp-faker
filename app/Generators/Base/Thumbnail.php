<?php

namespace App\Generators\Base;

class Thumbnail
{
    public function __invoke()
    {
        $faker = \Faker\Factory::create('en_GB');

        return $faker->wpImage;
    }
}