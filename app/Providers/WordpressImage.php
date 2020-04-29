<?php

namespace App\Providers;

use Faker\Provider\Base;

class WordpressImage extends Base
{
    protected static $images = [210, 212, 213, 278, 341];

    public function wpImage()
    {
        return static::randomElement(static::$images);
    }

}

